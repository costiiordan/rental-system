<?php

namespace App\View\Components;

use App\Models\AttributeValues;
use App\Models\Constants\AttributeReference;
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

        $this->item->prices = $this->item->prices->sortBy([
            ['duration_unit', 'desc'],
            ['duration', 'asc'],
        ]);

        return view('components.list-item')->with([
            'bike' => $this->item,
            'attributeValues' => $this->parseItemAttributesValues($this->item),
            'category' => $this->getCategory($this->item),
            'interval' => $interval,
            'intervalPrice' => $interval ? $this->itemRepository->calculatePriceForItem($this->item, $interval->from, $interval->to): null,
        ]);
    }

    private function parseItemAttributesValues(Item $item): array
    {
        $attributes = [];

        foreach ($item->attributeValues as $attributeValue) {
            if ($attributeValue->attribute->reference === AttributeReference::CATEGORY) {
                continue;
            }

            $attributes[] = $attributeValue;
        }

        return $attributes;
    }

    private function getCategory(Item $item): ?AttributeValues
    {
        foreach ($item->attributeValues as $attributeValue) {
            if ($attributeValue->attribute->reference === AttributeReference::CATEGORY) {
                return $attributeValue;
            }
        }

        return null;
    }
}
