<?php

namespace App\View\Components;

use App\Models\Item;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PriceListItem extends Component
{
    public function __construct(public Item $item) { }

    public function render(): View
    {
        return view('components.price-list-item')->with([
            'bike' => $this->item,
            'category' => $this->item->category(),
        ]);
    }
}
