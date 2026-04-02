<x-app-layout>
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="max-w-7xl mx-auto mb-8">
            <div class="bg-gradient-to-r from-[#AF368D] to-[#3E8DE3] rounded-[40px] p-8 shadow-lg text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-3xl font-black italic uppercase tracking-wider text-white">Pusat Kendali Admin 🛠️</h1>
                    <p class="mt-1 font-bold opacity-90 text-lg">Halo Bos Admin, {{ Auth::user()->name }}! Siap mengelola petualangan hari ini?</p>
                </div>
                {{-- Ornamen hiasan --}}
                <div class="absolute right-[-20px] top-[-20px] text-[150px] opacity-20 rotate-12 pointer-events-none">⚙️</div>
            </div>
        </div>

        {{-- Statistik Ringkas --}}
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[30px] border-b-8 border-blue-400 shadow-sm">
                <p class="text-gray-500 font-bold uppercase text-xs tracking-widest">Total Petualang</p>
                <h3 class="text-4xl font-black text-blue-600 mt-1">1,240 <span class="text-sm font-medium text-gray-400">Anak</span></h3>
            </div>
            <div class="bg-white p-6 rounded-[30px] border-b-8 border-yellow-400 shadow-sm">
                <p class="text-gray-500 font-bold uppercase text-xs tracking-widest">Member Premium</p>
                <h3 class="text-4xl font-black text-yellow-500 mt-1">85 <span class="text-sm font-medium text-gray-400">Aktif</span></h3>
            </div>
            <div class="bg-white p-6 rounded-[30px] border-b-8 border-[#AF368D] shadow-sm">
                <p class="text-gray-500 font-bold uppercase text-xs tracking-widest">Sesi Bermain</p>
                <h3 class="text-4xl font-black text-[#AF368D] mt-1">542 <span class="text-sm font-medium text-gray-400">Hari ini</span></h3>
            </div>
        </div>

        {{-- Tabel Daftar User --}}
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-[40px] shadow-sm border-4 border-[#3E8DE310] overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Daftar Sahabat Kiara</h3>
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-xl font-bold text-sm transition">
                        📥 Download Laporan
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-8 py-4 font-black text-gray-400 uppercase text-xs tracking-widest">Nama</th>
                                <th class="px-8 py-4 font-black text-gray-400 uppercase text-xs tracking-widest">Email</th>
                                <th class="px-8 py-4 font-black text-gray-400 uppercase text-xs tracking-widest text-center">Status</th>
                                <th class="px-8 py-4 font-black text-gray-400 uppercase text-xs tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            {{-- Contoh Baris Data (Nanti diganti @foreach($users as $user)) --}}
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="px-8 py-5">
                                    <div class="font-bold text-gray-800 text-lg italic">Budi Santoso</div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Daftar: 2 jam yang lalu</div>
                                </td>
                                <td class="px-8 py-5 text-gray-600 font-medium">budi@email.com</td>
                                <td class="px-8 py-5 text-center">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black bg-yellow-100 text-yellow-700 border border-yellow-200">
                                        💎 PREMIUM
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button class="text-magenta font-black text-xs hover:underline uppercase mr-4">Edit</button>
                                    <button class="text-red-400 font-black text-xs hover:underline uppercase">Hapus</button>
                                </td>
                            </tr>
                            {{-- Akhir baris contoh --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>