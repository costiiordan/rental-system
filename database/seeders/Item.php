<?php

namespace Database\Seeders;

use App\Models\AttributeValues;
use App\Models\Constants\AttributeReference;
use App\Models\Constants\CategoryReference;
use App\Models\Constants\ItemStatus;
use App\Models\Constants\PriceDurationType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class Item extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getData();

        foreach ($data as $itemData) {
            $item = new \App\Models\Item([
                'name' => $itemData['name'],
                'sku' => $itemData['sku'],
                'description' => $itemData['description'],
                'status' => $itemData['status'],
                'image_path' => $itemData['image_path'],
            ]);

            $item->save();



            foreach ($itemData['price'] as $price) {
                $item->prices()->create([
                    'duration_unit' => $price['duration_unit'],
                    'duration' => $price['duration'],
                    'price' => $price['price'],
                ]);
            }

            foreach ($itemData['attributes'] as $attributeId) {
                if ($attributeId !== null) {
                    $item->attributeValues()->attach($attributeId);
                }
            }
        }
    }

    private function getData(): array
    {
        $attributeValues = AttributeValues::with('attribute')->get();

        return [
            [
                'name' => 'Mondraker Prime 29 L',
                'sku' => 'mondraker-prime-29-l',
                'description' => 'The Mondraker Prime 29 is a high-performance mountain bike designed for serious riders. It features a lightweight aluminum frame, 29-inch wheels for improved stability and speed, and a full suspension system for maximum comfort on rough terrain.',
                'status' => ItemStatus::ACTIVE,
                'image_path' => 'items/01JZCRTX3G1EWTDRQE7XJ7G5V5.jpg',
                'price' => [
                    [
                        'duration_unit' => PriceDurationType::HOUR,
                        'duration' => 4,
                        'price' => 180
                    ],
                    [
                        'duration_unit' => PriceDurationType::DAY,
                        'duration' => 1,
                        'price' => 250
                    ]
                ],
                'attributes' => [
                    $this->getAttributeIdByReference($attributeValues, AttributeReference::CATEGORY, CategoryReference::ELECTRIC_MOUNTAIN_BIKE),
                ],
            ],
            [
                'name' => 'Mondraker Prime 29 M',
                'sku' => 'mondraker-prime-29-m',
                'description' => 'The Mondraker Prime 29 is a high-performance mountain bike designed for serious riders. It features a lightweight aluminum frame, 29-inch wheels for improved stability and speed, and a full suspension system for maximum comfort on rough terrain.',
                'status' => ItemStatus::ACTIVE,
                'image_path' => 'items/01JZCRTX3G1EWTDRQE7XJ7G5V5.jpg',
                'price' => [
                    [
                        'duration_unit' => PriceDurationType::HOUR,
                        'duration' => 4,
                        'price' => 180
                    ],
                    [
                        'duration_unit' => PriceDurationType::DAY,
                        'duration' => 1,
                        'price' => 250
                    ]
                ],
                'attributes' => [
                    $this->getAttributeIdByReference($attributeValues, AttributeReference::CATEGORY, CategoryReference::ELECTRIC_MOUNTAIN_BIKE),
                ],
            ],
        ];
    }

    private function getAttributeIdByReference(Collection $attributeValues, string $attributeReference, string $valueReference): ?int
    {
        foreach ($attributeValues as $attributeValue) {
            if ($attributeValue->attribute->reference === $attributeReference && $attributeValue->reference === $valueReference) {
                return $attributeValue->id;
            }
        }

        return null;
    }
}
