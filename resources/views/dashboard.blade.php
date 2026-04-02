<x-app-layout>
    {{-- Custom CSS --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap');
        
        body { 
            font-family: 'Fredoka', sans-serif; 
            background-color: #F0F7FF !important; 
            overflow-x: hidden;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(8deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .floating-asset {
            position: fixed; z-index: 0; opacity: 0.35;
            animation: float 7s ease-in-out infinite;
            pointer-events: none; user-select: none;
        }

        .text-magenta { color: #AF368D; }
        .bg-magenta { background-color: #AF368D; }
    </style>

    {{-- Background Assets --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none" style="z-index: 0;">
        <span class="floating-asset text-8xl" style="top: 10%; left: -2%;">🏎️</span>
        <span class="floating-asset text-6xl text-blue-400" style="top: 55%; left: 5%; animation-delay: 2s;">🏹</span>
        <span class="floating-asset text-[180px]" style="top: -5%; right: -2%; animation-delay: 1s; opacity: 0.15;">☁️</span>
        <span class="floating-asset text-7xl text-magenta" style="top: 45%; right: 5%; animation-delay: 3s;">🎣</span>
        <span class="floating-asset text-7xl" style="bottom: 10%; left: 20%; animation-delay: 4s; opacity: 0.2;">✨</span>
    </div>


    <div class="py-6 px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            
            {{-- Notifikasi Sukses/Error dari Controller --}}
            @if(session('success'))
                <div class="bg-green-100 border-2 border-green-200 text-green-700 px-6 py-4 rounded-[25px] font-bold mb-6 flex items-center gap-3">
                    <span>✨</span> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-2 border-red-200 text-red-700 px-6 py-4 rounded-[25px] font-bold mb-6 flex items-center gap-3">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif

            {{-- Hero --}}
            <div class="relative bg-gradient-to-br from-[#AF368D] to-[#3E8DE3] rounded-[50px] p-8 md:p-12 shadow-2xl overflow-hidden mb-10 transform transition hover:rotate-1">
                <div class="absolute top-[-20%] left-[-10%] w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between">
                    <div class="text-center md:text-left text-white">
                        <h1 class="text-4xl md:text-6xl font-black mb-4 leading-tight">Main Seru, <br>Jadi Juara!</h1>
                        <p class="text-white/90 text-lg font-medium max-w-md mb-8 italic">Pilih tantanganmu dan kumpulkan bintang sebanyak-banyaknya! 🚀</p>
                        <a href="#arena" class="bg-yellow-400 text-gray-900 px-10 py-4 rounded-[25px] font-black text-xl shadow-[0_8px_0_rgb(202,138,4)] hover:shadow-none hover:translate-y-1 transition-all inline-block">MULAI PETUALANGAN! 🏎️</a>
                    </div>
                    <div class="hidden md:block animate-bounce text-[150px]">🎮</div>
                </div>
            </div>

            {{-- Grid Stat --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="bg-white/95 backdrop-blur-sm rounded-[40px] p-8 shadow-xl border-b-[10px] border-yellow-100 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-yellow-50 rounded-3xl flex items-center justify-center text-4xl mb-4">⭐</div>
                    <p class="text-gray-400 font-bold uppercase text-xs tracking-widest">Tabungan Bintang</p>
                    <h2 class="text-6xl font-black text-magenta my-2">{{ number_format($totalPoints ?? 0) }}</h2>
                </div>
                <div class="bg-white/95 backdrop-blur-sm rounded-[40px] p-8 shadow-xl border-b-[10px] border-blue-100 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center text-4xl mb-4">🏅</div>
                    <p class="text-gray-400 font-bold uppercase text-xs tracking-widest">Status</p>
                    <h2 class="text-4xl font-black text-gray-800 my-4 italic">Pintar!</h2>
                </div>
                <div class="bg-white/95 backdrop-blur-sm rounded-[40px] p-8 shadow-xl border-b-[10px] border-green-100 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-green-50 rounded-3xl flex items-center justify-center text-4xl mb-4">🔥</div>
                    <p class="text-gray-400 font-bold uppercase text-[10px] mb-4">Energi Bermain</p>
                    <div class="flex gap-2 mb-4">
                        @for($i = 1; $i <= 3; $i++)
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ (Auth::user()->daily_games_count ?? 0) >= $i ? 'bg-gray-100 opacity-30' : 'bg-green-400 text-white animate-pulse' }}">⚡</div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- BANNER UPGRADE PREMIUM --}}
            @if(!Auth::user()->is_premium)
            <div class="bg-gradient-to-r from-yellow-400 to-orange-400 rounded-[35px] p-6 mb-10 shadow-lg flex flex-col md:flex-row items-center justify-between border-4 border-white">
                <div class="flex items-center gap-5 mb-4 md:mb-0">
                    <div class="text-5xl">💎</div>
                    <div>
                        <h4 class="text-xl font-black text-orange-900">Upgarte Premimu</h4>
                        <p class="text-orange-800 font-medium">Upgrade cuma <strong>Rp 10.000</strong> perbulan untuk akses semua fitur.</p>
                    </div>
                </div>
                <a href="{{ route('premium.checkout') }}" class="bg-white text-orange-600 px-8 py-3 rounded-2xl font-black shadow-md hover:scale-105 transition-transform">
                    UPGRADE SEKARANG!
                </a>
            </div>
            @endif

            {{-- ARENA GAME --}}
            <h3 id="arena" class="text-3xl font-black text-gray-800 mb-8 ml-4 flex items-center gap-3">
                <span class="bg-magenta w-3 h-8 rounded-full"></span>
                ARENA BERMAIN SAMBIL BELAJAR
            </h3>

            @php
                $myGames = [
                    ['name' => 'Balap Mobil', 'icon' => '🏎️', 'materi' => 'Perkalian', 'route' => 'game.racing', 'active' => true],
                    ['name' => 'Memanah', 'icon' => '🏹', 'materi' => 'Pembagian', 'route' => '#', 'active' => false],
                    ['name' => 'Tarik Tambang', 'icon' => '💪', 'materi' => 'Tambah & Kurang', 'route' => '#', 'active' => false],
                    ['name' => 'Menembak', 'icon' => '🎯', 'materi' => 'Pecahan Dasar', 'route' => '#', 'active' => false],
                    ['name' => 'Memancing', 'icon' => '🎣', 'materi' => 'Urutan Angka', 'route' => '#', 'active' => false],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
                @foreach($myGames as $g)
                <div class="group bg-white/95 rounded-[50px] overflow-hidden shadow-lg border-2 border-transparent {{ $g['active'] ? 'hover:border-magenta hover:shadow-2xl' : 'opacity-80' }} transition-all duration-500">
                    <div class="p-8">
                        <div class="flex items-center gap-6 mb-8">
                            <div class="bg-magenta/5 w-24 h-24 rounded-[30px] flex items-center justify-center text-6xl transition-transform {{ $g['active'] ? 'group-hover:scale-110' : '' }} shadow-inner">
                                {{ $g['icon'] }}
                            </div>
                            <div>
                                <h4 class="text-3xl font-black text-gray-800">{{ $g['name'] }}</h4>
                                <p class="text-magenta font-bold uppercase text-xs tracking-tighter italic">Belajar {{ $g['materi'] }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            @php
                                $ezLink = $g['active'] ? route($g['route'], ['difficulty' => 'easy']) : '#';
                                $normLink = $g['active'] ? route($g['route'], ['difficulty' => 'normal']) : '#';
                                $hardLink = $g['active'] ? route($g['route'], ['difficulty' => 'hard']) : '#';
                            @endphp

                            <a href="{{ $ezLink }}" class="{{ $g['active'] ? 'bg-green-100 text-green-600 border-green-200 hover:bg-green-500 hover:text-white' : 'bg-gray-100 text-gray-400 cursor-default' }} py-4 rounded-2xl font-black text-center border-b-4 transition-all text-xs">EASY</a>
                            <a href="{{ $normLink }}" class="{{ $g['active'] ? 'bg-yellow-100 text-yellow-600 border-yellow-200 hover:bg-yellow-500 hover:text-white' : 'bg-gray-100 text-gray-400 cursor-default' }} py-4 rounded-2xl font-black text-center border-b-4 transition-all text-xs">NORMAL</a>
                            
                            {{-- Kondisi Level Hard --}}
                            @if(Auth::user()->is_premium)
                                <a href="{{ $hardLink }}" class="bg-red-100 text-red-600 border-red-200 hover:bg-red-500 hover:text-white py-4 rounded-2xl font-black text-center border-b-4 transition-all text-xs">HARD</a>
                            @else
                                <a href="{{ route('premium.checkout') }}" class="bg-gray-100 text-gray-400 py-4 rounded-2xl font-black text-center border-b-4 opacity-60 flex flex-col items-center justify-center text-[10px]">
                                    HARD <span>🔒</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <footer class="bg-magenta relative pt-20 pb-10 overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-16 bg-[#F0F7FF] rounded-b-[60px]"></div>
        <div class="max-w-6xl mx-auto px-4 text-center relative z-10 text-white">
            <h4 class="text-3xl font-black mb-2 tracking-tighter">KIARA EDUPLAY</h4>
            <p class="font-medium mb-10 opacity-80 italic">Tempat belajar paling asyik! 🇮🇩</p>
            <p class="text-[10px] font-bold opacity-50 uppercase tracking-widest">© 2026 • Sahabat Pintar Si Kecil</p>
        </div>
    </footer>
</x-app-layout>