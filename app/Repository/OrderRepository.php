<?php

namespace App\Repository;

use App\Exceptions\NoItemsSelectedException;
use App\Exceptions\UnavailableItemsInSelectionException;
use App\Models\Constants\SelectedItemType;
use App\Models\ItemBooking;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;

class OrderRepository
{
    public function __construct(private CartRepository $selectedItemsRepository)
    { }

    public function saveOrder(array $orderData): Order
    {
        $selectedItems = $this->selectedItemsRepository->getCart();

        $this->checkForUnavailableItems($selectedItems);

        if ($selectedItems->isEmpty()) {
            throw new NoItemsSelectedException();
        }

        $order = $this->createOrder($orderData, $selectedItems);

        $this->saveSelectedItemsToOrder($order, $selectedItems);

        $this->selectedItemsRepository->clearSelectedItems();

        return $order;
    }

    private function checkForUnavailableItems(Collection $selectedItems): void
    {
        $unavailableItems = $this->selectedItemsRepository->getUnavailableItems($selectedItems);

        if ($unavailableItems->isNotEmpty()) {
            $itemList = $unavailableItems->map(function($item) {
                return $item['item']->name. ' (SKU: '.$item['item']->sku.')';
            })->implode(', ');

            throw new UnavailableItemsInSelectionException($itemList);
        }
    }

    private function createOrder(array $orderData, Collection $selectedItems): Order
    {
        $orderData['total'] = $this->calculateOrderTotal($selectedItems);
        $orderData['hash'] = $this->getOrderHash();

        $order = new Order($orderData);

        $order->save();

        return $order;
    }

    private function calculateOrderTotal(Collection $selectedItems): int
    {
        $total = 0;

        foreach ($selectedItems as $selectedItem) {
            if ($selectedItem['type'] === SelectedItemType::ITEM) {
                $total += $selectedItem['price'];

                continue;
            }

            if ($selectedItem['type'] === SelectedItemType::DISCOUNT) {
                $total -= $selectedItem['value'];
            }
        }

        return $total;
    }

    private function getOrderHash(): string
    {
        return md5(uniqid(rand(), true));
    }

    private function saveSelectedItemsToOrder(Order $order, Collection $selectedItems): void
    {
        foreach ($selectedItems as $selectedItem) {
            if ($selectedItem['type'] === SelectedItemType::ITEM) {
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'item_id' => $selectedItem['itemId'],
                    'name' => $this->getOrderItemName($selectedItem),
                    'price' => $selectedItem['price'],
                ]);

                $orderItem->save();

                $itemBooking = new ItemBooking([
                    'item_id' => $selectedItem['itemId'],
                    'order_id' => $order->id,
                    'from_date' => $selectedItem['bookingFromDate'],
                    'to_date' => $selectedItem['bookingToDate'],
                ]);

                $itemBooking->save();

                continue;
            }

            if ($selectedItem['type'] === SelectedItemType::DISCOUNT) {
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'name' => $selectedItem['name'],
                    'price' => -$selectedItem['value'],
                ]);

                $orderItem->save();
            }
        }
    }

    private function getOrderItemName(array $selectedItem): string
    {
        return 'Inchieriere ' . $selectedItem['item']->name . ' (' . $selectedItem['bookingFromDate']->format('d.m.Y H:i') . ' - ' . $selectedItem['bookingToDate']->format('d.m.Y H:i') . ')';
    }
}
