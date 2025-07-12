<?php

namespace Database\Seeders;

use App\Models\AttributeValues;
use App\Models\Constants\AttributeReference;
use App\Models\Constants\CategoryReference;
use Illuminate\Database\Seeder;

class Attribute extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getData();

        foreach ($data as $attribute) {
            $attributeModel = new \App\Models\Attribute([
                'name' => $attribute['name'],
                'reference' => $attribute['reference'] ?? null,
            ]);

            $attributeModel->save();

            foreach ($attribute['values'] as $value) {
                $attributeValueModel = new AttributeValues([
                    'attribute_id' => $attributeModel->id,
                    'value' => $value['name'],
                    'reference' => $value['reference'] ?? null,
                ]);

                $attributeValueModel->save();
            }
        }
    }

    private function getData(): array
    {
        return [
            'Categorie' => [
                'name' => [
                    'ro' => 'Categorie',
                    'en' => 'Category',
                ],
                'reference' => AttributeReference::CATEGORY,
                'values' => [
                    [
                        'name' => [
                            'ro' => 'Copii',
                            'en' => 'Kids',
                        ],
                        'reference' => CategoryReference::KIDS,
                    ],
                    [
                        'name' => [
                            'ro' => 'Enduro copii',
                            'en' => 'Enduro Kids',
                        ],
                        'reference' => CategoryReference::ENDURO_KIDS,
                    ],
                    [
                        'name' => [
                            'ro' => 'Enduro electric',
                            'en' => 'Electric Enduro',
                        ],
                        'reference' => CategoryReference::ELECTRIC_ENDURO,
                    ],
                    [
                        'name' => [
                            'ro' => 'Super enduro bike park',
                            'en' => 'Super enduro bike park',
                        ],
                        'reference' => CategoryReference::SUPER_ENDURO_BIKE_PARK,
                    ],
                    [
                        'name' => [
                            'ro' => 'Downhill',
                            'en' => 'Downhill',
                        ],
                        'reference' => CategoryReference::DOWNHILL,
                    ],
                    [
                        'name' => [
                            'ro' => 'Mountain bike electric',
                            'en' => 'Electric mmountain bike',
                        ],
                        'reference' => CategoryReference::ELECTRIC_MOUNTAIN_BIKE,
                    ]
                ]
            ],
            [
                'name' => ['ro' => 'Brand', 'en' => 'Brand',],
                'values' => [
                    ['name' => ['ro' => 'Mondraker', 'en' => 'Mondraker',]],
                    ['name' => ['ro' => 'Polygon', 'en' => 'Polygon',],],
                    ['name' => ['ro' => 'Cinelli', 'en' => 'Cinelli',],]
                ],
            ],
            [
                'name' => ['ro' => 'Diametru roti', 'en' => 'Wheel size',],
                'values' => [
                    ['name' => ['ro' => '29"', 'en' => '29"'],],
                    ['name' => ['ro' => '27.5"', 'en' => '27.5"'],],
                    ['name' => ['ro' => '26"', 'en' => '26"'],],
                    ['name' => ['ro' => 'Mullet 29"/27.5"', 'en' => 'Mullet 29"/27.5"'],]
                ],
            ],
            [
                'name' => ['ro' => 'Capacitate baterie', 'en' => 'Battery',],
                'values' => [
                    ['name' => ['ro' => '500Wh', 'en' => '500Wh'],],
                    ['name' => ['ro' => '625Wh', 'en' => '625Wh'],],
                    ['name' => ['ro' => '720Wh', 'en' => '720Wh'],],
                    ['name' => ['ro' => '750Wh', 'en' => '750Wh'],]
                ],
            ],
            [
                'name' => ['ro' => 'Inaltime recomandata', 'en' => 'Rider height',],
                'values' => [
                    ['name' => ['ro' => 'pana la 130cm', 'en' => 'up to 130cm'],],
                    ['name' => ['ro' => '130-145cm', 'en' => '130-145cm'],],
                    ['name' => ['ro' => '145-170cm', 'en' => '145-170cm'],],
                    ['name' => ['ro' => '170-185cm', 'en' => '170-185cm'],],
                    ['name' => ['ro' => 'peste 185cm', 'en' => 'over 185cm'],]
                ],
            ],
            [
                'name' => ['ro' => 'Marime', 'en' => 'Size',],
                'values' => [
                    ['name' => ['ro' => 'Small', 'en' => 'Small'],],
                    ['name' => ['ro' => 'Medium', 'en' => 'Medium'],],
                    ['name' => ['ro' => 'Large', 'en' => 'Large'],],
                    ['name' => ['ro' => 'X-Large', 'en' => 'X-Large'],],
                    ['name' => ['ro' => 'XX-Large', 'en' => 'XX-Large'],],
                ],
            ],
        ];
    }
}
