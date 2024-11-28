<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberLevel>
 */
class MemberLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'description' => fake()->sentence(),
            'can_train_without_trainer' => fake()->boolean(),
            'needs_orientation' => fake()->boolean(),
            'has_trainer_access' => fake()->boolean(),
            'max_guests' => fake()->numberBetween(1, 10),
            'guest_fee' => fake()->randomFloat(2, 10000, 100000),
        ];
    }
}
