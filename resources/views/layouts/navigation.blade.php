<body class="font-sans antialiased">
    <div class="min-h-screen">
        
        {{-- PINDAHKAN NAVBAR KE SINI --}}
        <nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b-4 border-[#3E8DE315] sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                            <img src="{{ asset('assets/logo/logo_kiara.jpeg') }}" class="h-12 w-12 rounded-2xl shadow-md border-2 border-white group-hover:rotate-6 transition" alt="Logo">
                            <span class="hidden sm:inline text-xl font-black text-[#AF368D]">KIARA <span class="text-[#3E8DE3]">EDUPLAY</span></span>
                        </a>
                    </div>

                    <div class="hidden md:flex items-center gap-8">
                        <div class="flex items-center gap-6 border-r-2 border-gray-100 pr-6">
                            <a href="{{ route('dashboard') }}" class="font-bold {{ request()->routeIs('dashboard') ? 'text-[#AF368D]' : 'text-gray-700 hover:text-[#AF368D]' }} transition">Beranda</a>
                            <a href="{{ route('game.leaderboard') }}" class="font-bold {{ request()->routeIs('game.leaderboard') ? 'text-[#AF368D]' : 'text-gray-700 hover:text-[#AF368D]' }} transition">Papan Juara</a>
                            
                            @if(!Auth::user()->is_premium)
                                <a href="{{ route('premium.checkout') }}" class="bg-yellow-400 text-yellow-900 px-4 py-1.5 rounded-xl font-black text-[11px] shadow-[0_3px_0_rgb(202,138,4)] hover:shadow-none hover:translate-y-0.5 transition-all">
                                    💎 UPGRADE
                                </a>
                            @else
                                <div class="px-3 py-1 rounded-full border-2 bg-yellow-50 border-yellow-200 text-yellow-600 text-[10px] font-black">
                                    💎 PREMIUM
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col items-end leading-tight">
                            <span class="text-sm font-black text-gray-800">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="text-[10px] font-bold text-red-400 hover:text-red-600 uppercase">Keluar 👋</button>
                            </form>
                        </div>
                    </div>

                    <div class="flex md:hidden items-center">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-[#AF368D] hover:bg-[#AF368D10] focus:outline-none transition-all">
                            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile Nav --}}
            <div x-show="open" x-transition class="md:hidden bg-white border-b-4 border-[#AF368D10] px-4 pt-2 pb-6 space-y-2 shadow-xl">
                <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-2xl font-bold {{ request()->routeIs('dashboard') ? 'bg-[#AF368D05] text-[#AF368D]' : 'text-gray-700' }}">Beranda</a>
                @if(!Auth::user()->is_premium)
                    <a href="{{ route('premium.checkout') }}" class="block px-4 py-3 rounded-2xl font-bold bg-yellow-400 text-yellow-900">💎 Upgrade Premium</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-3 rounded-2xl font-bold text-red-500">Keluar 👋</button>
                </form>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>
    </div>
</body>