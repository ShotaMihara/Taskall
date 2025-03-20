<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Goal;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(50),
            'description' => $this->faker->realText(200),
            'deadline' => $this->faker->date,
            'progress' => $this->faker->numberBetween(0, 100),
            'is_completed' => $this->faker->boolean,
        ];
    }
}
