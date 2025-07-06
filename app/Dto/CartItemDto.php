<?php

namespace App\Dto;

use App\Models\Item;
use Illuminate\Support\Carbon;

class CartItemDto
{
    public string $id;
    public Item $item;
    public Carbon $fromDate;
    public Carbon $toDate;
    public int $price;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->item = $data['item'];
        $this->fromDate = $data['fromDate'];
        $this->toDate = $data['toDate'];
        $this->price = $data['price'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'item' => $this->item->toArray(),
            'fromDate' => $this->fromDate->format('Y-m-d H:i'),
            'toDate' => $this->toDate->format('Y-m-d H:i'),
            'price' => $this->price,
        ];
    }
}
