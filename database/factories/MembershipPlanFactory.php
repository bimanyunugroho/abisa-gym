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
    protected $timeSlots = [
        // Pagi
        ['start' => '06:00', 'end' => '08:00'],
        ['start' => '08:00', 'end' => '10:00'],
        ['start' => '10:00', 'end' => '12:00'],
        // Siang
        ['start' => '12:00', 'end' => '14:00'],
        ['start' => '14:00', 'end' => '16:00'],
        // Sore
        ['start' => '16:00', 'end' => '18:00'],
        ['start' => '18:00', 'end' => '20:00'],
        // Malam
        ['start' => '19:00', 'end' => '21:00'],
        ['start' => '20:00', 'end' => '22:00']
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil 2-4 time slots secara random
        $selectedTimeSlots = collect($this->timeSlots)
            ->random(fake()->numberBetween(2, 4))
            ->values()
            ->toArray();

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
            'available_times' => $selectedTimeSlots,
            'is_active' => fake()->boolean(),
        ];
    }
}
