<?php

namespace App\View\Components;

use App\Models\AttributeValues;
use App\Models\Constants\AttributeReference;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PriceListItem extends Component
{
    public function __construct(public Item $item) { }

    public function render(): View
    {
        $this->item->prices = $this->item->prices->sortBy([
            ['duration_unit', 'desc'],
            ['duration', 'asc'],
        ]);

        return view('components.price-list-item')->with([
            'bike' => $this->item,
            'category' => $this->getCategory($this->item),
        ]);
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
