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
            Category::class,
            Attribute::class,
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'costi.iordan@gmail.com',
            'password' => Hash::make('pass123')
        ]);
    }
}
