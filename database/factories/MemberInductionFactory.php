<?php

namespace Database\Factories;

use App\Models\EquipmentCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberInduction>
 */
class MemberInductionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'MEMBER')->inRandomOrder()->first()?->id 
                ?? User::factory()->create(['role' => 'MEMBER'])->id,
            'trainer_id' => User::where('role', 'TRAINER')->inRandomOrder()->first()?->id 
                ?? User::factory()->create(['role' => 'TRAINER'])->id,
            'equipment_category_id' => EquipmentCategory::inRandomOrder()->first()?->id 
                ?? EquipmentCategory::factory(),
            'slug' => fake()->slug(),
            'induction_date' => fake()->date(),
            'notes' => fake()->sentence(),
            'is_completed' => fake()->boolean(),
        ];
    }
}
