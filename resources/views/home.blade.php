<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Game Kamu!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <x-game-card 
                    title="Balap Matematika" 
                    category="Math" 
                    image="https://placehold.co/600x400/blue/white?text=Math+Game" 
                    color="blue-500" 
                />

                <x-game-card 
                    title="Susun Huruf" 
                    category="Language" 
                    image="https://placehold.co/600x400/orange/white?text=Language+Game" 
                    color="orange-500" 
                />

            </div>
        </div>
    </div>
</x-app-layout>