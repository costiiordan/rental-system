<?php

namespace App\Repository;

use App\Models\Item;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SelectedItemsRepository
{
    public function __construct(private ItemRepository $itemRepository)
    { }

    public function addItem(array $data): void
    {
        $selectedItems = session('selectedItems', []);

        $bookingFromDate = Carbon::createFromFormat('Y-m-d H:i', $data['fromDateTime']);
        $bookingToDate = Carbon::createFromFormat('Y-m-d H:i', $data['toDateTime']);

        $itemIsAlreadySelected = collect($selectedItems)->contains(function ($item) use ($data, $bookingFromDate, $bookingToDate) {
            $itemFromDate = Carbon::createFromFormat('Y-m-d H:i', $item['fromDateTime']);
            $itemToDate = Carbon::createFromFormat('Y-m-d H:i', $item['toDateTime']);

            return $item['itemId'] === $data['itemId'] &&
                (
                    $bookingFromDate->isBetween($itemFromDate, $itemToDate) ||
                    $bookingToDate->isBetween($itemFromDate, $itemToDate)
                );
        });

        if ($itemIsAlreadySelected) {
            return;
        }

        $selectedItems[] = [
            'id' => uniqid(),
            'itemId' => $data['itemId'],
            'fromDateTime' => $data['fromDateTime'],
            'toDateTime' => $data['toDateTime'],
        ];

        session(['selectedItems' => $selectedItems]);
    }

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
                'id' => $selectedItem['id'],
                'itemId' => $selectedItem['itemId'],
                'item' => $item,
                'bookingFromDate' => $bookingFromDate,
                'bookingToDate' => $bookingToDate,
                'price' => $price,
            ];
        });
    }

    public function getUnavailableItems(Collection $selectedItems): Collection
    {
        return $selectedItems->filter(function ($selectedItem) {
            return !$selectedItem['item']->isAvailableInInterval($selectedItem['bookingFromDate'], $selectedItem['bookingToDate']);
        });
    }

    public function clearSelectedItems(): void
    {
        session()->forget('selectedItems');
    }

    public function removeItem(string $id): void
    {
        $selectedItems = session('selectedItems', []);
        $selectedItems = array_filter($selectedItems, function ($item) use ($id) {
            return $item['id'] !== $id;
        });

        session(['selectedItems' => array_values($selectedItems)]);
    }
}
