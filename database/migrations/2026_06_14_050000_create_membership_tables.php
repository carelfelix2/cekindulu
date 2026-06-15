<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_plans', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->unsignedBigInteger('price');
            $t->unsignedSmallInteger('duration_days');
            $t->text('description')->nullable();
            $t->json('features')->nullable();
            $t->boolean('is_active')->default(true)->index();
            $t->timestamps();
        });

        Schema::create('transactions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('membership_plan_id')->constrained('membership_plans')->cascadeOnDelete();
            $t->string('invoice_number', 50)->unique();
            $t->unsignedBigInteger('amount');
            $t->string('payment_method', 50)->default('manual_transfer');
            $t->enum('status', ['pending', 'paid', 'failed', 'expired', 'cancelled'])->default('pending')->index();
            $t->string('payment_proof')->nullable();
            $t->text('admin_notes')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->timestamp('expires_at')->nullable();
            $t->timestamps();
        });

        Schema::create('user_memberships', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('membership_plan_id')->constrained('membership_plans')->cascadeOnDelete();
            $t->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            $t->timestamp('started_at')->nullable();
            $t->timestamp('ends_at')->nullable();
            $t->boolean('is_active')->default(true)->index();
            $t->timestamps();

            $t->index(['user_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_memberships');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('membership_plans');
    }
};
