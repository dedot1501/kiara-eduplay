<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LevelContent;
use App\Models\Game;
use Illuminate\Http\Request;

class LevelContentController extends Controller
{
    public function index() {
        $contents = LevelContent::with('game')->get();
        $games = Game::all();
        return view('admin.level-contents.index', compact('contents', 'games'));
    }

    public function store(Request $request) {
        LevelContent::create($request->all());
        return back()->with('success', 'Soal berhasil ditambahkan!');
    }
}