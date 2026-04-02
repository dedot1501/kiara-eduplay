<x-app-layout>
    <div class="py-12 bg-[#FFFEF9] min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-[40px] shadow-2xl border-b-8 border-[#AF368D] p-10 text-center relative overflow-hidden">
            
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#AF368D] opacity-5 rounded-full"></div>
            <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-[#3E8DE3] opacity-5 rounded-full"></div>

            <div class="relative z-10">
                <div class="text-6xl mb-4">💎</div>
                <h2 class="text-3xl font-black text-gray-800 mb-2 tracking-tight">Upgrade Premium</h2>
                <p class="text-gray-500 mb-8 font-medium italic">Main sepuasnya tanpa batas!</p>
                
                <div class="bg-gradient-to-br from-[#AF368D10] to-[#3E8DE310] p-6 rounded-3xl mb-8 border-2 border-dashed border-[#AF368D30]">
                    <p class="text-xs text-gray-400 uppercase font-black tracking-widest mb-1">Total Investasi Belajar</p>
                    <p class="text-5xl font-black text-[#AF368D]">Rp 10.000</p>
                </div>

                <div class="space-y-4">
                    <button id="pay-button" class="w-full bg-[#AF368D] hover:bg-[#3E8DE3] text-white py-5 rounded-2xl font-black text-xl shadow-lg transition-all transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-3">
                        <span>MULAI PEMBAYARAN</span>
                        <span class="text-2xl">🚀</span>
                    </button>

                    <div id="loading-status" class="hidden animate-pulse flex flex-col items-center">
                        <div class="w-8 h-8 border-4 border-[#AF368D] border-t-transparent rounded-full animate-spin mb-2"></div>
                        <p class="text-xs font-bold text-orange-500 uppercase tracking-tighter text-center">Menunggu Pembayaran...<br><span class="text-[10px] lowercase italic text-gray-400">Silakan selesaikan di aplikasi HP kamu</span></p>
                    </div>

                    <a href="{{ route('dashboard') }}" class="block mt-6 text-gray-400 font-bold text-sm hover:text-[#AF368D] transition">
                        Kembali ke Dashboard
                    </a>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center space-x-4 opacity-40">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png" class="h-4" alt="QRIS">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" class="h-4" alt="DANA">
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    
    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        const loadingStatus = document.getElementById('loading-status');

        payButton.onclick = function (e) {
            e.preventDefault();
            
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    /* Jika berhasil, langsung lempar ke dashboard */
                    window.location.href = "{{ route('dashboard') }}?status=success";
                },
                onPending: function (result) {
                    /* Jika dapet kode bayar tapi belum di-scan */
                    payButton.classList.add('hidden');
                    loadingStatus.classList.remove('hidden');
                },
                onError: function (result) {
                    alert("Waduh, koneksi terputus. Coba lagi ya!");
                    location.reload();
                },
                onClose: function () {
                    alert('Selesaikan pembayaranmu agar bisa main sepuasnya! 😊');
                }
            });
        };
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap');
        h2, button, p.text-5xl, a { font-family: 'Fredoka One', cursive; }
    </style>
</x-app-layout>