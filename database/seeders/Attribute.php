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
        DB::table('attributes')->insert([
            ['name' => 'Inaltime recomandata'],
            ['name' => 'Capacitate baterie'],
            ['name' => 'Recomandat pentru'],
            ['name' => 'Diametru roti'],
            ['name' => 'Brand'],
            ['name' => 'Gama'],
        ]);
    }
}
