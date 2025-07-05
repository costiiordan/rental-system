<?php

namespace App\Http\Controllers;

use App\Exceptions\NoItemsSelectedException;
use App\Exceptions\UnavailableItemsInSelectionException;
use App\Http\Requests\SaveOrderRequest;
use App\Models\Constants\PaymentMethods;
use App\Models\Order;
use App\Repository\OrderRepository;
use App\Repository\SelectedItemsRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(SelectedItemsRepository $selectedItemsRepository)
    {
        $selectedItems = $selectedItemsRepository->getSelectedItems();

        if ($selectedItems->isEmpty()) {
            return $this->returnToHomeWithError('No items selected for checkout.');
        }

        return view('checkout.index', [
            'selectedItems' => $selectedItems,
        ]);
    }

    public function saveOrder(SaveOrderRequest $request, OrderRepository $orderRepository): RedirectResponse
    {
        $orderData = $request->validated();

        try {
            $order = $orderRepository->saveOrder($orderData);
        } catch (NoItemsSelectedException) {
            return $this->returnToHomeWithError('No items selected for checkout.');
        } catch (UnavailableItemsInSelectionException $exception) {
            return  $this->returnToHomeWithError("Urmatoarele produse nu sunt disponibile in intervalul selectat: ".$exception->getMessage());
        }

        return redirect()->route('checkout.success', [
            'orderId' => $order->id,
            'hash' => $order->hash,
        ]);
    }

    public function success(string $orderId, string $hash): View
    {
        $order = Order::where('id', $orderId)
            ->where('hash', $hash)
            ->firstOrFail();

        if ($order->payment_method === PaymentMethods::CASH) {
            return view('checkout.order_confirmation_cash', [
                'order' => $order,
            ]);
        }

        abort(404);
    }

    private function returnToHomeWithError(string $message): RedirectResponse
    {
        return redirect()->route('home')->with('error', $message);
    }
}
