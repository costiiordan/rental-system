<?php

namespace App\Repository;

use App\Exceptions\NoItemsSelectedException;
use App\Models\ItemBooking;
use App\Models\Order;
use App\Models\OrderItem;

class OrderRepository
{
    public function __construct(private SelectedItemsRepository $selectedItemsRepository)
    {
    }

    public function saveOrder(array $orderData): Order
    {
        $selectedItems = $this->selectedItemsRepository->getSelectedItems();

        if ($selectedItems->isEmpty()) {
            throw new NoItemsSelectedException();
        }

        $totalPrice = 0;

        foreach ($selectedItems as $selectedItem) {
            $totalPrice += $selectedItem['price'];
        }

        $orderData['total'] = $totalPrice;
        $orderData['hash'] = md5(uniqid(rand(), true));

        $order = new Order($orderData);

        $order->save();

        foreach ($selectedItems as $selectedItem) {
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'item_id' => $selectedItem['itemId'],
                'name' => 'Inchieriere '.$selectedItem['item']->name. ' ('.$selectedItem['bookingFromDate']->format('d.m.Y H:i').' - '.$selectedItem['bookingToDate']->format('d.m.Y H:i').')',
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
        }

        $this->selectedItemsRepository->clearSelectedItems();

        return $order;
    }
}
