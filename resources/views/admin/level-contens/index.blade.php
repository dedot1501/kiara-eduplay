<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow">
            <h2 class="text-2xl font-bold mb-6">Tambah Soal Baru</h2>
            
            <form action="{{ route('admin.levels.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label>Pilih Game</label>
                    <select name="game_id" class="w-full rounded border-gray-300">
                        @foreach($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Level</label>
                        <select name="difficulty" class="w-full rounded border-gray-300">
                            <option value="easy">Easy (Gratis)</option>
                            <option value="normal">Normal (Gratis)</option>
                            <option value="hard">Hard (Premium)</option>
                        </select>
                    </div>
                    <div>
                        <label>Premium?</label>
                        <select name="is_premium" class="w-full rounded border-gray-300">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label>Pertanyaan</label>
                    <input type="text" name="question" class="w-full rounded border-gray-300" placeholder="Contoh: 5 + 5">
                </div>

                <div>
                    <label>Jawaban</label>
                    <input type="text" name="answer" class="w-full rounded border-gray-300" placeholder="Contoh: 10">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold">Simpan Soal</button>
            </form>
        </div>
    </div>
</x-app-layout>