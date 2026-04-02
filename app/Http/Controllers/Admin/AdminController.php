<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil semua user kecuali admin itu sendiri (opsional)
        // Diurutkan dari yang paling baru daftar
        $users = User::where('role', 'user')->latest()->get();

        // Menghitung statistik untuk card di dashboard
        $totalUsers = User::where('role', 'user')->count();
        $totalPremium = User::where('is_premium', true)->count();
        
        // Kirim data ke view
        return view('admin.dashboard', compact('users', 'totalUsers', 'totalPremium'));
    }

    // Fungsi tambahan jika kamu mau hapus user dari dashboard
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}