<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score; 
use App\Models\LevelContent;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * DASHBOARD UTAMA
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Mengambil semua game
        $games = Game::all();
        
        // Ambil total skor user
        $totalPoints = Score::where('user_id', $user->id)->sum('points');

        // Logika Reset Limit Harian
        $today = now()->toDateString();
        if ($user->last_game_date !== $today) {
            $user->update([
                'daily_games_count' => 0,
                'last_game_date' => $today
            ]);
        }

        return view('dashboard', compact('games', 'totalPoints'));
    }

    /**
     * HALAMAN GAME RACE MATH
     */
    public function racing($difficulty = 'easy')
    {
        $user = Auth::user();
        $today = now()->toDateString();

        // 1. Validasi Difficulty
        if (!in_array($difficulty, ['easy', 'normal', 'hard'])) {
            $difficulty = 'easy';
        }

        // 2. Proteksi Level Hard (Khusus Premium)
        if ($difficulty === 'hard' && !$user->is_premium) {
            return redirect()->route('dashboard')->with('error', 'Opps! Level SULIT 🔴 hanya untuk member Premium 💎');
        }

        // 3. Cek Limit Main (Khusus User Gratis)
        if (!$user->is_premium) {
            if ($user->last_game_date !== $today) {
                $user->update(['daily_games_count' => 0, 'last_game_date' => $today]);
            }

            if ($user->daily_games_count >= 3) {
                return redirect()->route('dashboard')->with('error', 'Limit bensin gratis kamu sudah habis (3/3). Yuk Upgrade ke Premium!');
            }

            // Tambah jumlah main
            $user->increment('daily_games_count');
        }

        // 4. Ambil Soal dari Database
        $questions = LevelContent::where('difficulty', $difficulty)
                        ->inRandomOrder()
                        ->limit(10)
                        ->get()
                        ->map(function($item) {
                            // Cek apakah content sudah array atau masih JSON string
                            $data = is_string($item->content) ? json_decode($item->content, true) : $item->content;
                            
                            // Ambil question dan answer, jika tidak ada pakai default
                            return [
                                'question' => $data['question'] ?? ($item->question ?? '0 x 0'),
                                'answer' => $data['answer'] ?? ($item->answer ?? 0)
                            ];
                        });

        // Fallback jika soal kosong
        if ($questions->isEmpty()) {
            $questions = collect([
                ['question' => '2 x 2', 'answer' => 4],
                ['question' => '5 x 3', 'answer' => 15],
                ['question' => '10 x 2', 'answer' => 20],
                ['question' => '4 x 4', 'answer' => 16],
                ['question' => '6 x 2', 'answer' => 12],
            ]);
        }

        // 5. Ambil Skor Tertinggi User
        $highScore = Score::where('user_id', $user->id)
                          ->where('difficulty', $difficulty)
                          ->max('points') ?? 0;

        /** * PERBAIKAN DI SINI:
         * Karena nama file kamu 'racing.blade.php' di dalam folder 'game', 
         * maka kita panggil 'game.racing'
         */
        return view('game.racing', compact('questions', 'difficulty', 'highScore'));
    }

    /**
     * SIMPAN SKOR (Via AJAX)
     */
    public function saveScore(Request $request)
    {
        $request->validate([
            'points' => 'required|integer',
            'difficulty' => 'required|in:easy,normal,hard',
            'status' => 'required|string',
        ]);

        $user = Auth::user();
        $finalPoints = $request->points;

        // Bonus kemenangan
        if ($request->status === 'win') {
            $finalPoints += 50;
        }

        Score::create([
            'user_id' => $user->id,
            'game_name' => 'Matematika Balap',
            'points' => $finalPoints,
            'difficulty' => $request->difficulty,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Skor Berhasil Disimpan! 🏎️💨',
            'added_points' => $finalPoints
        ]);
    }

    /**
     * LEADERBOARD
     */
    public function leaderboard()
    {
        $topScores = User::select('users.name', DB::raw('SUM(scores.points) as total_points'))
            ->join('scores', 'users.id', '=', 'scores.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_points', 'desc')
            ->take(10)
            ->get();

        return view('game.leaderboard', compact('topScores'));
    }
}