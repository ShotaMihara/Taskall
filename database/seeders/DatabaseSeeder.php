<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\GorlFactory;
use Database\Factories\TaskFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Goal;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ユーザーを作成
        $users = User::factory(10)->create();

        // 各ユーザーに対してゴールを作成
        $users->each(function ($user) {
            Goal::factory(3)->create([
                'user_id' => $user->id,
            ])->each(function ($goal) {
                // 各ゴールに対してタスクを作成
                Task::factory(5)->create([
                    'goal_id' => $goal->id,
                ]);
            });
        });
    }
}