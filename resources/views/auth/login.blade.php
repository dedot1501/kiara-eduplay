<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap');
        
        /* Menghilangkan margin bawaan layout agar logo kita tidak terlalu turun */
        .min-h-screen > div:first-child { display: none !important; } 

        .min-h-screen {
            background: radial-gradient(circle at top left, #FDF2F8 0%, #E0F2FE 100%) !important;
            font-family: 'Fredoka', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Memastikan box login tetap cantik */
        .w-full.sm:max-w-md {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            border: 4px solid #ffffff;
            border-radius: 40px !important;
            box-shadow: 0 20px 50px rgba(175, 54, 141, 0.1) !important;
            padding: 2rem !important;
        }

        .text-kiara-magenta { color: #AF368D; }
        .text-kiara-blue { color: #3E8DE3; }
    </style>

    {{-- Logo Kiara (Hanya Satu Ini Saja) --}}
    <div class="flex flex-col items-center mb-6">
        <a href="/">
            <img src="{{ asset('assets/logo/logo_kiara.jpeg') }}" 
                 class="w-24 h-24 rounded-[30px] shadow-xl border-4 border-white hover:rotate-6 transition-transform duration-300" 
                 alt="Logo Kiara">
        </a>
        <h2 class="mt-4 text-2xl font-black text-kiara-magenta uppercase tracking-tight">
            Selamat <span class="text-kiara-blue">Datang!</span>
        </h2>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block font-bold text-gray-700 ml-1 mb-1">Email Sahabat Kiara</label>
            <x-text-input id="email" class="block w-full rounded-2xl border-gray-200 focus:ring-[#AF368D]" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <div>
            <label class="block font-bold text-gray-700 ml-1 mb-1">Kata Sandi Rahasia</label>
            <x-text-input id="password" class="block w-full rounded-2xl border-gray-200 focus:ring-[#AF368D]" type="password" name="password" required />
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" class="rounded border-gray-300 text-[#AF368D] focus:ring-[#AF368D]" name="remember">
                <span class="ms-2 font-bold text-gray-600 italic">Ingat Saya</span>
            </label>
            <a class="font-bold text-[#3E8DE3] hover:text-[#AF368D]" href="{{ route('password.request') }}">Lupa Sandi?</a>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-[#AF368D] to-[#3E8DE3] text-white py-4 rounded-2xl font-black text-lg shadow-[0_5px_0_rgb(140,40,110)] hover:shadow-none hover:translate-y-1 transition-all">
            MASUK SEKARANG 🚀
        </button>
        
        <p class="text-center text-sm font-bold text-gray-500 mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="text-[#AF368D] hover:underline">Daftar di sini!</a>
        </p>
    </form>
</x-guest-layout>