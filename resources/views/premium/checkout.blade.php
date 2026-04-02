<x-app-layout>
    {{-- Tambahkan script Midtrans Snap JS --}}
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    <div class="py-12 bg-[#FFFEF9] min-h-screen">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white rounded-[40px] shadow-2xl border-4 border-[#AF368D] overflow-hidden">
                
                <div class="bg-[#AF368D] p-8 text-center">
                    <h1 class="text-3xl font-black text-white uppercase tracking-wider">Aktivasi Akun Premium 💎</h1>
                    <p class="text-pink-100 font-bold mt-2 text-sm italic">Buka semua fitur seru Kiara Eduplay!</p>
                </div>

                <div class="p-10 text-center">
                    <div class="mb-10">
                        <div class="text-6xl mb-4">🚀</div>
                        <h2 class="text-2xl font-black text-gray-800 mb-2">Satu Langkah Lagi!</h2>
                        <p class="text-gray-600 font-bold text-lg">Klik tombol di bawah untuk memilih metode pembayaran (QRIS, GoPay, atau ShopeePay)</p>
                    </div>
                    
                    <div class="mb-8 bg-gray-50 p-6 rounded-[30px] border-2 border-dashed border-gray-200">
                        <p class="text-gray-400 font-black uppercase text-xs tracking-widest">Total Investasi Pintar</p>
                        <h2 class="text-5xl font-black text-magenta">Rp 10.000</h2>
                    </div>

                    <div class="space-y-4">
                        {{-- Tombol Pemicu Snap --}}
                        <button id="pay-button" class="w-full bg-green-500 hover:bg-green-600 text-white py-5 rounded-2xl font-black text-xl shadow-lg transform hover:-translate-y-1 transition active:scale-95 flex items-center justify-center gap-3">
                            BAYAR SEKARANG 💳
                        </button>
                        
                        <a href="{{ route('dashboard') }}" class="inline-block text-gray-400 font-bold hover:text-[#AF368D] transition">
                            Nanti Saja, Kembali ke Dashboard
                        </a>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 text-center border-t border-gray-100">
                    <div class="flex justify-center space-x-6">
                        <span class="text-xs font-bold text-gray-400 uppercase">⚡ Proses Instan</span>
                        <span class="text-xs font-bold text-gray-400 uppercase">🔒 Aman & Terpercaya</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // snapToken didapat dari Controller
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    /* Anda bisa arahkan ke halaman sukses */
                    window.location.href = "{{ route('dashboard') }}";
                    alert("Pembayaran berhasil! Selamat bermain ✨");
                },
                onPending: function (result) {
                    /* Terjadi jika user belum bayar tapi sudah tutup snap */
                    alert("Menunggu pembayaranmu ya!");
                },
                onError: function (result) {
                    /* Terjadi jika ada error sistem */
                    alert("Yah, pembayaran gagal. Coba lagi nanti ya!");
                },
                onClose: function () {
                    /* Ketika user menutup popup snap */
                    alert('Kamu belum menyelesaikan pembayaran.');
                }
            });
        });
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap');
        body { font-family: 'Fredoka', sans-serif; }
        h1, h2, button, a { font-family: 'Fredoka', sans-serif; font-weight: 700; }
        .text-magenta { color: #AF368D; }
    </style>
</x-app-layout>