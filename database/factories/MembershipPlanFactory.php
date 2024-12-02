<?php

namespace Database\Factories;

use App\Enums\DurationTypeEnum;
use App\Models\MemberLevel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MembershipPlan>
 */
class MembershipPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $timeRanges = [];
        $numRanges = fake()->numberBetween(2, 4);
        
        for ($i = 0; $i < $numRanges; $i++) {
            $startHour = fake()->numberBetween(6, 20);
            $startMinute = fake()->randomElement(['00', '30']);
            $start = sprintf("%02d:%s", $startHour, $startMinute);
            
            $endHour = min($startHour + fake()->numberBetween(1, 3), 23);
            $endMinute = fake()->randomElement(['00', '30']);
            $end = sprintf("%02d:%s", $endHour, $endMinute);
            
            $timeRanges[] = [
                'start' => $start,
                'end' => $end
            ];
        }

        return [
            'name' => strtoupper(fake()->words(3, true)),
            'slug' => fn (array $attributes) => Str::slug($attributes['name']),
            'member_level_id' => MemberLevel::factory(),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(100000, 1000000),
            'duration_days' => fake()->numberBetween(30, 365),
            'duration_type' => fake()->randomElement(DurationTypeEnum::values()),
            'visit_limit' => fake()->numberBetween(10, 100),
            'access_all_branches' => fake()->boolean(),
            'available_times' => $timeRanges,
            'is_active' => fake()->boolean(),
        ];
    }
}
