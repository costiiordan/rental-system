<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            Attribute::class,
            Item::class,
        ]);

        User::factory()->create([
            'name' => 'Costi Iordan',
            'email' => 'costi.iordan@gmail.com',
            'password' => Hash::make('pass123')
        ]);

        User::factory()->create([
            'name' => 'PlayBike Office',
            'email' => 'office@playbike.ro',
            'password' => Hash::make('PlayBike!@#')
        ]);
    }
}
