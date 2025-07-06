<?php

namespace App\Dto;

use Illuminate\Support\Collection;

class CartDto
{
    /**
     * @var \Illuminate\Support\Collection<\App\Dto\CartItemDto> $items
     */
    public Collection $items;
    /**
     * @var \Illuminate\Support\Collection<\App\Dto\CartDiscountDto> $discounts
     */
    public Collection $discounts;
    public int $total;

    public function __construct(array $data)
    {
        $this->items = $data['items'];
        $this->discounts = $data['discounts'];
        $this->total = $data['total'];
    }

    public function toArray(): array
    {
        return [
            'items' => $this->items->map(fn($item) => $item->toArray())->all(),
            'discounts' => $this->discounts->map(fn($discount) => $discount->toArray())->all(),
            'total' => $this->total,
        ];
    }
}
