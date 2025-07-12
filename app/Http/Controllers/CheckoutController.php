<?php

namespace App\Http\Controllers;

use App\Exceptions\NoItemsSelectedException;
use App\Exceptions\UnavailableItemsInSelectionException;
use App\Http\Requests\SaveOrderRequest;
use App\Models\Constants\PaymentMethods;
use App\Models\Order;
use App\Repository\OrderRepository;
use App\Repository\CartRepository;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CheckoutController extends Controller
{
    public function index(CartRepository $cartRepository)
    {
        $cart = $cartRepository->getCart();

        if ($cart->items->isEmpty()) {
            return $this->returnToHomeWithError(__('Nu sunt produse în coșul de cumpărături.'));
        }

        return view('checkout.index', [
            'cart' => $cart,
        ]);
    }

    public function saveOrder(SaveOrderRequest $request, OrderRepository $orderRepository): RedirectResponse
    {
        $orderData = $request->validated();

        try {
            $order = $orderRepository->saveOrder($orderData);
        } catch (NoItemsSelectedException) {
            return $this->returnToHomeWithError(__('Nu sunt produse în coșul de cumpărături.'));
        } catch (UnavailableItemsInSelectionException $exception) {
            return  $this->returnToHomeWithError(
                __(
                    'Urmatoarele produse nu sunt disponibile in intervalul selectat: :products',
                    ['products' => $exception->getMessage()]
                )
            );
        }

        return redirect(LaravelLocalization::localizeUrl(route('checkout.success', [
            'orderId' => $order->id,
            'hash' => $order->hash,
        ])));
    }

    public function success(string $orderId, string $hash): View
    {
        $order = Order::with('orderItems.itemBooking')
            ->where('id', $orderId)
            ->where('hash', $hash)
            ->firstOrFail();

        $date = Carbon::now();

        foreach ($order->orderItems as $item) {
            $itemDate = Carbon::createFromFormat('Y-m-d H:i:s', $item->itemBooking->from_date);
            if ($itemDate->isAfter($date)) {
                $date = $itemDate;
            }
        }

        if ($order->payment_method === PaymentMethods::CASH) {
            return view('checkout.order_confirmation_cash', [
                'order' => $order,
                'date' => $date,
            ]);
        }

        if ($order->payment_method === PaymentMethods::BANK_TRANSFER) {
            return view('checkout.order_confirmation_bank_transfer', [
                'order' => $order,
                'date' => $date,
            ]);
        }

        abort(404);
    }

    private function returnToHomeWithError(string $message): RedirectResponse
    {
        return redirect(LaravelLocalization::localizeUrl(route('home')))->with('error', $message);
    }
}
