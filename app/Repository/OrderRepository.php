<?php

namespace App\Repository;

use App\Dto\CartDto;
use App\Dto\CartItemDto;
use App\Exceptions\NoItemsSelectedException;
use App\Exceptions\UnavailableItemsInSelectionException;
use App\Models\Constants\OrderStatus;
use App\Models\Constants\PaymentMethods;
use App\Models\ItemBooking;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class OrderRepository
{
    public function __construct(private CartRepository $cartRepository)
    { }

    public function saveOrder(array $orderData): Order
    {
        $cart = $this->cartRepository->getCart();

        $this->checkForUnavailableItems($cart);

        if ($cart->items->isEmpty()) {
            throw new NoItemsSelectedException();
        }

        $order = $this->createOrder($orderData, $cart);

        $this->saveCartItemsToOrder($order, $cart->items);
        $this->saveDiscountsToOrder($order, $cart->discounts);

        $this->cartRepository->emptyCart();

        return $order;
    }

    public function getOrderPickupDate(Order $order): Carbon
    {
        $date = null;

        foreach ($order->orderItems as $item) {
            $itemDate = Carbon::createFromFormat('Y-m-d H:i:s', $item->itemBooking->from_date);
            if ($date ===null || $itemDate->isBefore($date)) {
                $date = $itemDate;
            }
        }

        return $date;
    }

    private function checkForUnavailableItems(CartDto $cart): void
    {
        $unavailableCartItems = $this->cartRepository->getUnavailableItems($cart->items);

        if ($unavailableCartItems->isNotEmpty()) {
            $itemList = $unavailableCartItems->map(function($cartItem) {
                return $cartItem->item->name. ' (SKU: '.$cartItem->item->sku.')';
            })->implode(', ');

            throw new UnavailableItemsInSelectionException($itemList);
        }
    }

    private function createOrder(array $orderData, CartDto $cart): Order
    {
        $orderData['total'] = $cart->total;
        $orderData['hash'] = $this->getOrderHash();

        if (in_array($orderData['payment_method'], [PaymentMethods::CASH, PaymentMethods::BANK_TRANSFER])) {
            $orderData['status'] = OrderStatus::PAYMENT_PENDING;
        } else {
            $orderData['status'] = OrderStatus::WAITING_PICKUP;
        }

        $order = new Order($orderData);

        $order->save();

        return $order;
    }

    private function getOrderHash(): string
    {
        return md5(uniqid(rand(), true));
    }

    private function saveCartItemsToOrder(Order $order, Collection $cartItems): void
    {
        foreach ($cartItems as $cartItem) {
            $itemBooking = new ItemBooking([
                'item_id' => $cartItem->item->id,
                'from_date' => $cartItem->fromDate,
                'to_date' => $cartItem->toDate,
            ]);

            $itemBooking->save();

            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'item_id' => $cartItem->item->id,
                'item_booking_id' => $itemBooking->id,
                'name' => $this->getOrderItemName($cartItem),
                'price' => $cartItem->price,
            ]);

            $orderItem->save();
        }
    }

    private function saveDiscountsToOrder(Order $order, Collection $discounts): void
    {
        foreach ($discounts as $discount) {
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'name' => $discount->name,
                'price' => $discount->value,
            ]);

            $orderItem->save();
        }
    }

    private function getOrderItemName(CartItemDto $cartItem): string
    {
        return 'Inchieriere ' . $cartItem->item->name . ' (' . $cartItem->fromDate->format('d.m.Y H:i') . ' - ' . $cartItem->toDate->format('d.m.Y H:i') . ')';
    }
}
