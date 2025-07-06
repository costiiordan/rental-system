<?php

namespace App\Repository;

use App\Dto\CartDiscountDto;
use App\Dto\CartDto;
use App\Models\Constants\AttributeReference;
use App\Models\Constants\CategoryReference;
use Illuminate\Support\Collection;

class QuantityDiscount
{
    public const ELIGIBLE_DISCOUNT_CATEGORIES = [
        CategoryReference::KIDS,
        CategoryReference::ENDURO_KIDS,
        CategoryReference::SUPER_ENDURO_BIKE_PARK,
        CategoryReference::DOWNHILL,
        CategoryReference::ELECTRIC_ENDURO,
        CategoryReference::ELECTRIC_MOUNTAIN_BIKE,
    ];
    public const DISCOUNTS = [
        3 => [
            'minItems' => 3,
            'percentage' => 10,
            'name' => '10% Discount pentru 3 sau mai multe biciclete',
        ],
        5 => [
            'minItems' => 5,
            'percentage' => 15,
            'name' => '15% Discount pentru 5 sau mai multe biciclete',
        ],
        7 => [
            'minItems' => 7,
            'percentage' => 20,
            'name' => '20% Discount pentru 7 sau mai multe biciclete',
        ],
    ];

    public function apply(CartDto $selectedItems): Collection
    {
        $eligibleItemsCount = 0;
        $discountPrice = 0;

        foreach ($selectedItems->items as $selectedItem) {
            foreach ($selectedItem->item->attributeValues as $attributeValue) {
                if (
                    $attributeValue->attribute->reference === AttributeReference::CATEGORY &&
                    in_array($attributeValue->reference, self::ELIGIBLE_DISCOUNT_CATEGORIES)
                ) {
                    $eligibleItemsCount++;
                    $discountPrice += $selectedItem->price;

                    continue 2;
                }
            }
        }

        $discountValue = 0;

        if ($eligibleItemsCount >= self::DISCOUNTS[7]['minItems']) {
            $discountValue = $discountPrice * self::DISCOUNTS[7]['percentage'] / 100;
            $discountName = self::DISCOUNTS[7]['name'];
        } elseif ($eligibleItemsCount >= self::DISCOUNTS[5]['minItems']) {
            $discountValue = $discountPrice * self::DISCOUNTS[5]['percentage'] / 100;
            $discountName = self::DISCOUNTS[5]['name'];
        } elseif ($eligibleItemsCount >= self::DISCOUNTS[3]['minItems']) {
            $discountValue = $discountPrice * self::DISCOUNTS[3]['percentage'] / 100;
            $discountName = self::DISCOUNTS[3]['name'];
        }

        $discounts = collect();

        if ($discountValue > 0) {
            $discounts->add(new CartDiscountDto([
                'name' => $discountName,
                'value' => $discountValue,
            ]));
        }

        return $discounts;
    }
}
