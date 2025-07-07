<?php

namespace App\Repository;

use App\Dto\CartDto;
use App\Dto\CartItemDto;
use App\Exceptions\NoItemsSelectedException;
use App\Exceptions\UnavailableItemsInSelectionException;
use App\Models\ItemBooking;
use App\Models\Order;
use App\Models\OrderItem;
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
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'item_id' => $cartItem->item->id,
                'name' => $this->getOrderItemName($cartItem),
                'price' => $cartItem->price,
            ]);

            $orderItem->save();

            $itemBooking = new ItemBooking([
                'item_id' => $cartItem->item->id,
                'order_id' => $order->id,
                'from_date' => $cartItem->fromDate,
                'to_date' => $cartItem->toDate,
            ]);

            $itemBooking->save();
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
