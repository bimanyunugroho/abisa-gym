<?php

use App\Enums\DurationTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('member_level_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('duration_days')->nullable(); // Null untuk unlimited
            $table->enum('duration_type', DurationTypeEnum::values())->default(DurationTypeEnum::DAYS->value);
            $table->integer('visit_limit')->nullable(); // Null untuk unlimited visits
            $table->boolean('access_all_branches')->default(false); // Akses ke semua cabang
            $table->json('available_times')->nullable(); // Waktu yang tersedia (jam gym)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};
