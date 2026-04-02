<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    // Tambahkan baris ini:
    protected $fillable = ['name', 'slug', 'description'];
}
