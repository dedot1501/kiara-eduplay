<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Penting untuk mencatat error
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    }

    /**
     * Menampilkan Halaman Checkout
     */
    public function checkout()
    {
        $user = Auth::user();

        if ($user->is_premium) {
            return redirect()->route('dashboard')->with('success', 'Kamu sudah jadi member Premium! ✨');
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'KIARA-' . $user->id . '-' . time(),
                'gross_amount' => 10000, 
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'enabled_payments' => ['qris', 'gopay', 'shopeepay'], 
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Simpan token ke database agar bisa dipanggil kembali jika halaman di-refresh
            $user->update(['payment_token' => $snapToken]);

            return view('premium.checkout', compact('snapToken'));

        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Gagal memuat pembayaran. Pastikan koneksi internet stabil.');
        }
    }

    /**
     * Webhook Callback: Dipanggil otomatis oleh server Midtrans
     */
    public function callback(Request $request) 
    {
        // 1. Ambil data dari request Midtrans
        $serverKey = config('services.midtrans.serverKey');
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signatureKey = $request->signature_key;
        $transactionStatus = $request->transaction_status;

        // 2. Validasi Signature (Keamanan agar tidak bisa dipalsukan orang lain)
        $hashed = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($hashed !== $signatureKey) {
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        // 3. Logika Update User jadi Premium
        // Order ID format: KIARA-{user_id}-{timestamp}
        $orderParts = explode('-', $orderId);
        $userId = $orderParts[1];
        
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Jika status sukses (settlement = lunas, capture = kartu kredit lunas)
        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            $user->update(['is_premium' => true]);
            Log::info("User ID {$userId} berhasil upgrade ke Premium.");
        }

        return response()->json(['status' => 'OK']);
    }
}