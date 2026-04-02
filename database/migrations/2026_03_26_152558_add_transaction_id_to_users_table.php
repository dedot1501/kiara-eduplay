<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mematikan transaksi otomatis agar stabil di Neon Postgres.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom untuk menyimpan token transaksi dari Midtrans
            $table->string('payment_token', 191)->nullable();
            
            // Kolom tambahan jika ingin mencatat ID order terakhir
            $table->string('last_order_id', 191)->nullable();
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