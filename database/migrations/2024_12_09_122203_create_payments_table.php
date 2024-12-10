<?php

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentTypeEnum;
use App\Enums\StatusPaymentEnum;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('no_payment')->nullable();
            $table->morphs('payable');
            $table->string('slug');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', PaymentMethodEnum::values());
            $table->enum('payment_type', PaymentTypeEnum::values());
            $table->enum('status', StatusPaymentEnum::values())->default(StatusPaymentEnum::PENDING->value);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
