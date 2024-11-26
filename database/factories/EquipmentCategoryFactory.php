<?php

namespace Database\Factories;

use App\Enums\DifficultyEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentCategory>
 */
class EquipmentCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'difficulty_level' => fake()->randomElement(DifficultyEnum::values()),
            'needs_supervision' => fake()->boolean(70),
            'created_at' => fake()->dateTimeBetween('2024-11-20', '2024-11-26'),
        ];
    }
}
