<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Goal;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'goal_id' => Goal::factory(),
            'name' => $this->faker->realText(20),
            'description' => $this->faker->realText(50),
            'deadline' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->numberBetween(0, 1),

        ];
    }
}
