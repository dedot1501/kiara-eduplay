<?php

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
        Schema::table('users', function (Blueprint $table) {
            // Kolom untuk menyimpan token transaksi dari Midtrans
            $table->string('payment_token')->nullable()->after('is_premium');
            
            // Kolom tambahan jika ingin mencatat ID order terakhir
            $table->string('last_order_id')->nullable()->after('payment_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['payment_token', 'last_order_id']);
        });
    }
};