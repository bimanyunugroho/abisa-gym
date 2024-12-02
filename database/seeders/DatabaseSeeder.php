<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\MemberInduction;
use App\Models\MemberLevel;
use App\Models\MembershipPlan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        EquipmentCategory::factory(5)->create();
        Equipment::factory(50)->create();
        User::factory(10)->create();
        MemberInduction::factory(10)->create();
        MemberLevel::factory(10)->create();
        MembershipPlan::factory(10)->create();
    }
}
