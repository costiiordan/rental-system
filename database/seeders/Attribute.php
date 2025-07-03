<?php

namespace Database\Seeders;

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
            'Brand' => ['Mondraker', 'Polygon', 'Cinelli'],
            'Diametru roti' => ['29"', '27.5"', '26"', 'Mullet 29"/27.5"'],
            'Capacitate baterie' => ['500Wh', '625Wh', '720Wh', '750Wh'],
            'Inaltime recomandata' => ['1,400 - 1,600 mm', '1,600 - 1,800 mm', '1,8+'],
        ];

        foreach ($data as $attributeName => $values) {
            $attributeId = DB::table('attributes')->insertGetId(['name' => $attributeName]);

            foreach ($values as $value) {
                DB::table('attribute_values')->insert([
                    'attribute_id' => $attributeId,
                    'value' => $value,
                ]);
            }
        }
    }
}
