<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\GorlFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Goal;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Goal::factory(5)->create([
            'user_id' => 1,
        ]);
    }
}
