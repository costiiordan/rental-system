<?php

namespace Database\Seeders;

use App\Models\Constants\AttributeReference;
use App\Models\Constants\CategoryReference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Attribute extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Categorie' => [
                'name' => 'Categorie',
                'reference' => AttributeReference::CATEGORY,
                'values' => [
                    [
                        'name' => 'Copii',
                        'reference' => CategoryReference::KIDS,
                    ],
                    [
                        'name' => 'Enduro copii',
                        'reference' => CategoryReference::ENDURO_KIDS,
                    ],
                    [
                        'name' => 'Enduro electric',
                        'reference' => CategoryReference::ELECTRIC_ENDURO,
                    ],
                    [
                        'name' => 'Super enduro bike park',
                        'reference' => CategoryReference::SUPER_ENDURO_BIKE_PARK,
                    ],
                    [
                        'name' => 'Downhill',
                        'reference' => CategoryReference::DOWNHILL,
                    ],
                    [
                        'name' => 'Mountain bike electric',
                        'reference' => CategoryReference::ELECTRIC_MOUNTAIN_BIKE,
                    ]
                ]
            ],
            [
                'name' => 'Brand',
                'values' => [
                    ['name' => 'Mondraker',],
                    ['name' => 'Polygon',],
                    ['name' => 'Cinelli',]
                ],
            ],
            [
                'name' => 'Diametru roti',
                'values' => [
                    ['name' => '29"'],
                    ['name' => '27.5"'],
                    ['name' => '26"'],
                    ['name' => 'Mullet 29"/27.5"']
                ],
            ],
            [
                'name' => 'Capacitate baterie',
                'values' => [
                    ['name' => '500Wh'],
                    ['name' => '625Wh'],
                    ['name' => '720Wh'],
                    ['name' => '750Wh']
                ],
            ],
            [
                'name' => 'Inaltime recomandata',
                'values' => [
                    ['name' => '90-130cm'],
                    ['name' => '130-145cm'],
                    ['name' => '145-170cm'],
                    ['name' => '170-185cm'],
                    ['name' => 'peste 185cm']
                ],
            ],
        ];

        foreach ($data as $attribute) {
            $attributeId = DB::table('attributes')->insertGetId(['name' => $attribute['name'], 'reference' => $attribute['reference'] ?? null]);

            foreach ($attribute['values'] as $value) {
                DB::table('attribute_values')->insert([
                    'attribute_id' => $attributeId,
                    'value' => $value['name'],
                    'reference' => $value['reference'] ?? null,
                ]);
            }
        }
    }
}
