<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap');
        
        /* Menghilangkan logo default layout agar tidak double */
        .min-h-screen > div:first-child { display: none !important; } 

        .min-h-screen {
            background: radial-gradient(circle at top left, #FDF2F8 0%, #E0F2FE 100%) !important;
            font-family: 'Fredoka', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Card Register Kiara */
        .w-full.sm:max-w-md {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            border: 4px solid #ffffff;
            border-radius: 40px !important;
            box-shadow: 0 20px 50px rgba(175, 54, 141, 0.1) !important;
            padding: 2.5rem !important;
        }

        .text-kiara-magenta { color: #AF368D; }
        .text-kiara-blue { color: #3E8DE3; }

        input:focus {
            border-color: #AF368D !important;
            --tw-ring-color: #AF368D !important;
        }
    </style>

    {{-- Logo Kiara & Judul --}}
    <div class="flex flex-col items-center mb-6">
        <a href="/">
            <img src="{{ asset('assets/logo/logo_kiara.jpeg') }}" 
                 class="w-24 h-24 rounded-[30px] shadow-xl border-4 border-white hover:rotate-6 transition-transform duration-300" 
                 alt="Logo Kiara">
        </a>
        <h2 class="mt-4 text-2xl font-black text-kiara-magenta uppercase tracking-tight">
            Daftar <span class="text-kiara-blue">Akun Baru!</span>
        </h2>
        <p class="text-gray-500 font-bold text-sm">Ayo bergabung dalam petualangan belajar!</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block font-bold text-gray-700 ml-1 mb-1">Nama Lengkap Petualang</label>
            <x-text-input id="name" class="block w-full rounded-2xl border-gray-200" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Siti Kiara" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-bold text-gray-700 ml-1 mb-1">Email Sahabat Kiara</label>
            <x-text-input id="email" class="block w-full rounded-2xl border-gray-200" type="email" name="email" :value="old('email')" required placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-bold text-gray-700 ml-1 mb-1">Kata Sandi Aman</label>
            <x-text-input id="password" class="block w-full rounded-2xl border-gray-200" type="password" name="password" required placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-bold text-gray-700 ml-1 mb-1">Ulangi Kata Sandi</label>
            <x-text-input id="password_confirmation" class="block w-full rounded-2xl border-gray-200" type="password" name="password_confirmation" required placeholder="Ketik ulang sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Tombol Register Kiara --}}
        <div class="pt-4">
            <button type="submit" class="w-full bg-gradient-to-r from-[#AF368D] to-[#3E8DE3] text-white py-4 rounded-2xl font-black text-lg shadow-[0_6px_0_rgb(140,40,110)] hover:shadow-none hover:translate-y-1 transition-all active:scale-95">
                DAFTAR SEKARANG 🌟
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm font-bold text-gray-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-kiara-magenta hover:underline">Masuk di sini!</a>
            </p>
        </div>
    </form>
</x-guest-layout>