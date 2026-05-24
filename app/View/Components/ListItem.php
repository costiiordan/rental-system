<?php

namespace App\View\Components;

use App\Models\Item;
use App\Repository\ItemRepository;
use App\Services\DateIntervalService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListItem extends Component
{
    public function __construct(
        public Item                   $item,
        public ?int                   $price = null,
        protected DateIntervalService $dateIntervalRepository,
        protected ItemRepository      $itemRepository,
    ) { }

    public function render(): View
    {
        $interval = $this->dateIntervalRepository->getInterval();

        return view('components.list-item')->with([
            'bike' => $this->item,
            'attributeValues' => $this->item->nonCategoryAttributeValues(),
            'category' => $this->item->category(),
            'interval' => $interval,
            'intervalPrice' => $interval ? $this->itemRepository->calculatePriceForItem($this->item, $interval->from, $interval->to): null,
        ]);
    }
}
