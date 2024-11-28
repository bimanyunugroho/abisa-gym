<?php

namespace Database\Factories;

use App\Enums\ConditionEnum;
use App\Models\EquipmentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryIds = EquipmentCategory::pluck('id')->toArray();
        
        return [
            'category_id' => $categoryIds ? fake()->randomElement($categoryIds) : EquipmentCategory::factory(),
            'name' => fake()->unique()->words(3, true),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->sentence(),
            'usage_instructions' => fake()->sentence(),
            'brand' => fake()->word(),
            'model' => fake()->word(),
            'purchase_date' => fake()->date(),
            'last_maintenance_date' => fake()->date(),
            'condition' => fake()->randomElement(ConditionEnum::values()),
            'is_active' => fake()->boolean(70),
        ];
    }
}
