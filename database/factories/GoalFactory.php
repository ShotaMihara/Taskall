<?php

namespace Database\Factories;

use App\Models\Goal;
use App\Models\User; // ユーザーを関連付けるためにインポート
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    protected $model = Goal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // ユーザーを関連付け
            'title' => $this->faker->sentence,
            'deadline' => $this->faker->date,
            'progress' => 0,
            'is_completed' => false,
        ];
    }
}
