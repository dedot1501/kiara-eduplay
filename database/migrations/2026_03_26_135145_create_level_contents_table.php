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
        Schema::create('level_contents', function (Blueprint $table) {
            $table->id();
            
            // Menghubungkan ke tabel games
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            
            $table->enum('difficulty', ['easy', 'normal', 'hard']);
            $table->text('question'); // Soal (bisa teks atau angka)
            $table->string('answer');   // Jawaban benar
            $table->boolean('is_premium')->default(false); // Soal khusus premium atau bukan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_contents');
    }
};