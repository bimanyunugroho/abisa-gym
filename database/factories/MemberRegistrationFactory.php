<?php

namespace Database\Factories;

use App\Enums\StatusMemberEnum;
use App\Models\MembershipPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberRegistration>
 */
class MemberRegistrationFactory extends Factory
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
            'membership_plan_id' => MembershipPlan::factory(),
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'visits_left' => 10,
            'slug' => fake()->slug(),
            'status' => fake()->randomElement(StatusMemberEnum::values()),
            'orientation_date' => now(),
            'orientation_completed' => true,
        ];
    }
}
