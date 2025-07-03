<?php

namespace Database\Seeders;

use App\Models\Constants\CategoryReference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Copii', 'reference' => CategoryReference::KIDS],
            ['name' => 'Enduro copii', 'reference' => CategoryReference::ENDURO_KIDS],
            ['name' => 'Enduro electric', 'reference' => CategoryReference::ELECTRIC_ENDURO],
            ['name' => 'Super enduro bike park', 'reference' => CategoryReference::SUPER_ENDURO_BIKE_PARK],
            ['name' => 'Downhill', 'reference' => CategoryReference::DOWNHILL],
            ['name' => 'Mountain bike electric', 'reference' => CategoryReference::ELECTRIC_MOUNTAIN_BIKE],
        ]);
    }
}
