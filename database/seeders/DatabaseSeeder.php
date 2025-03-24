<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Goal;
use App\Models\Task;
use Database\Factories\GoalFactory;
use Database\Factories\TaskFactory;
use App\Models\Resource;
use Database\Factories\ResourceFactory;
use Illuminate\Database\Seeder;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                // 各ゴールに対してリソースを作成
                Resource::factory(2)->create([
                    'goal_id' => $goal->id,
                ]);
            });
        });
    }
}