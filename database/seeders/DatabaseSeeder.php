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
        User::factory()->admin()->create([
            'name' => 'Gerald Supo',
            'email' => 'admin@example.com',
        ]);

        User::factory()->teacher()->count(5)->create();
        User::factory()->secretary()->count(2)->create();
        User::factory()->student()->count(20)->create();
    }

}
