<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@torycrown.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        \App\Models\GoldRate::create(['karat' => '18K', 'price_per_gram' => 8500, 'effective_date' => now()]);
        \App\Models\GoldRate::create(['karat' => '21K', 'price_per_gram' => 9800, 'effective_date' => now()]);
        \App\Models\GoldRate::create(['karat' => '22K', 'price_per_gram' => 10500, 'effective_date' => now()]);

        \App\Models\Setting::create(['key' => 'steadfast_api_key', 'value' => 'mock_key', 'group' => 'courier']);
        \App\Models\Setting::create(['key' => 'steadfast_secret_key', 'value' => 'mock_secret', 'group' => 'courier']);
    }
}
