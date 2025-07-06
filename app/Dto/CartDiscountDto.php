<?php

namespace App\Dto;

class CartDiscountDto
{
    public string $name;
    public int $value;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->value = $data['value'];
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
