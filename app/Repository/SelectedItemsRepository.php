<?php

namespace App\Repository;

use App\Models\Item;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SelectedItemsRepository
{
    public function __construct(private ItemRepository $itemRepository)
    { }

    public function getSelectedItems(): Collection
    {
        return collect(session('selectedItems', []))->map(function ($selectedItem) {
            $item = Item::with('prices')->find($selectedItem['itemId']);

            if (!$item) {
                return null;
            }

            $bookingFromDate = Carbon::createFromFormat('Y-m-d H:i', $selectedItem['fromDateTime']);
            $bookingToDate = Carbon::createFromFormat('Y-m-d H:i', $selectedItem['toDateTime']);

            $price = $this->itemRepository->calculatePriceForItem($item, $bookingFromDate, $bookingToDate);

            return [
                'itemId' => $selectedItem['itemId'],
                'item' => $item,
                'bookingFromDate' => $bookingFromDate,
                'bookingToDate' => $bookingToDate,
                'price' => $price,
            ];
        });
    }

    public function clearSelectedItems(): void
    {
        session()->forget('selectedItems');
    }
}
