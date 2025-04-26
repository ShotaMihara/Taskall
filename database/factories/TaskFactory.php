<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Goal;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * The current order value.
     *
     * @var int
     */
    protected static $order = 1;

    
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
            'status' => 0,
            'order' => self::$order++,
        ];
    }
}
