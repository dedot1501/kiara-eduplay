<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mematikan transaksi otomatis agar lancar di Neon Postgres.
     */
    public $withinTransaction = false;

    /**
     * Jalankan migration untuk membuat tabel scores.
     */
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            
            // Menghubungkan ke tabel users (siapa yang main)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Nama gamenya (misal: Race Math)
            $table->string('game_name');
            
            // Menggunakan 'points' agar sesuai dengan GameController (sum('points'))
            $table->integer('points'); 
            
            // Menggunakan 'difficulty' (Easy/Normal/Hard) untuk fitur Premium
            $table->enum('difficulty', ['easy', 'normal', 'hard'])->default('easy');
            
            $table->timestamps();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};