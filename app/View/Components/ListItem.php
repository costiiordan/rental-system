<?php

namespace App\View\Components;

use App\Dto\IntervalDto;
use App\Models\AttributeValues;
use App\Models\Constants\AttributeReference;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListItem extends Component
{
    public function __construct(
        public Item $item,
        public ?IntervalDto $interval = null,
        public ?int $price = null,
    ) { }

    public function render(): View
    {
        return view('components.list-item')->with([
            'bike' => $this->item,
            'attributeValues' => $this->parseItemAttributesValues($this->item),
            'category' => $this->getCategory($this->item),
            'interval' => $this->interval,
            'intervalPrice' => $this->price
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
