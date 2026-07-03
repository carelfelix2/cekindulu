<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('payment_gateway', 50)->default('manual_transfer')->after('payment_method');
            $table->string('payment_reference')->nullable()->after('payment_gateway');
            $table->string('snap_token')->nullable()->after('payment_reference');
            $table->text('snap_redirect_url')->nullable()->after('snap_token');
            $table->text('raw_payload')->nullable()->after('snap_redirect_url');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'payment_gateway',
                'payment_reference',
                'snap_token',
                'snap_redirect_url',
                'raw_payload'
            ]);
        });
    }
};
