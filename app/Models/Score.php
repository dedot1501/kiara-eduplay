<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    /**
     * Daftar kolom yang dapat diisi secara massal (Mass Assignment).
     * Kita sesuaikan dengan kolom migration: user_id, game_name, points, difficulty.
     */
    protected $fillable = [
        'user_id', 
        'game_name', 
        'points',      // Menggantikan 'score' agar lebih standar
        'difficulty'   // Menggantikan 'level' agar sesuai dengan enum (easy, normal, hard)
    ];

    /**
     * Relasi ke model User.
     * Setiap skor dicatat untuk satu user tertentu.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}