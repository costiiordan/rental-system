<?php

namespace App\Http\Controllers;

use App\Models\Constants\ItemStatus;
use App\Models\Item;
use App\Models\LockedDay;
use App\Repository\ItemRepository;
use App\Services\DateIntervalService;
use Illuminate\View\View;

class ItemDetailController extends Controller
{
    public function __invoke(
        Item $item,
        DateIntervalService $dateIntervalRepository,
        ItemRepository $itemRepository,
    ): View
    {
        if (!in_array($item->status, [ItemStatus::ACTIVE, ItemStatus::INACTIVE], true)) {
            abort(404);
        }

        $item->load('prices', 'attributeValues.attribute');

        $interval = $dateIntervalRepository->getInterval();

        $intervalPrice = $interval
            ? $itemRepository->calculatePriceForItem($item, $interval->from, $interval->to)
            : null;

        $isAvailable = $interval
            ? $item->isAvailableInInterval($interval->from, $interval->to)
            : null;

        $lockedDayHit = $interval
            ? LockedDay::whereIn('date', [
                $interval->from->format('Y-m-d'),
                $interval->to->format('Y-m-d'),
            ])->exists()
            : false;

        return view('item-detail', compact('item', 'interval', 'intervalPrice', 'isAvailable', 'lockedDayHit'));
    }
}
