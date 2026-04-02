<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelContent extends Model
{
    // Tambahkan baris ini:
    protected $fillable = ['game_id', 'difficulty', 'question', 'answer', 'is_premium'];

    // Tambahkan relasi agar kita bisa panggil nama gamenya nanti
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
