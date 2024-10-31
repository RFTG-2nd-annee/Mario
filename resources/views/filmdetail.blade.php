<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détail du film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-500">
                    <h1 class="text-4xl font-bold text-[#ff2d20] dark:text-[#ff2d20] text-center mb-12" style="margin: 20px;">
                        {{ __("Détails du film") }}
                    </h1>

                    <div class="max-w-3xl mx-auto" style="margin: 30px;">
                        @php
                            $filmId = request()->get('id');
                            $response = file_get_contents("http://localhost:8080/toad/film/getById?id={$filmId}");
                            $film = json_decode($response);
                        @endphp

                        @if(isset($film))
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 space-y-8"  style="margin: 20px;">
                                <div class="text-center mb-8" style="margin: 20px;">
                                    <input type="text" value="{{ $film->title }}" disabled style="border-radius: 10px;">
                                </div>

                                <div class="space-y-6">
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6" style="border-radius: 10px;">
                                        <h4 class="text-xl font-bold mb-4 text-[#ff2d20] dark:text-[#ff20]">Synopsis</h4>
                                        <textarea disabled class="w-full min-h-[100px] bg-white dark:bg-gray-600 rounded-lg p-4 resize-none text-gray-900 dark:text-gray-500">{{ $film->description }}</textarea>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6" style="border-radius: 10px;">
                                            <h4 class="text-xl font-bold mb-4 text-[#ff2d20] dark:text-[#ff2d20]">Informations générales</h4>
                                            <div class="space-y-4">
                                                <div class="flex items-center justify-between">
                                                    <label class="font-medium">Année de sortie</label>
                                                    <input type="text" value="{{ $film->releaseYear }}" disabled 
                                                        class="w-32 bg-white dark:bg-gray-600 rounded-lg px-3 py-2 text-right text-gray-900 dark:text-gray-500">
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <label class="font-medium">Durée</label>
                                                    <input type="text" value="{{ $film->length }} minutes" disabled 
                                                        class="w-32 bg-white dark:bg-gray-600 rounded-lg px-3 py-2 text-right text-gray-900 dark:text-gray-500">
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <label class="font-medium">Classification</label>
                                                    <input type="text" value="{{ $film->rating }}" disabled 
                                                        class="w-32 bg-white dark:bg-gray-600 rounded-lg px-3 py-2 text-right text-gray-900 dark:text-gray-500">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6" style="border-radius: 10px;">
                                            <h4 class="text-xl font-bold mb-4 text-[#ff2d20] dark:text-[#ff2d20]">Informations de location</h4>
                                            <div class="space-y-4">
                                                <div class="flex items-center justify-between">
                                                    <label class="font-medium">Durée de location</label>
                                                    <input type="text" value="{{ $film->rentalDuration }} jours" disabled 
                                                        class="w-32 bg-white dark:bg-gray-600 rounded-lg px-3 py-2 text-right text-gray-900 dark:text-gray-500">
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <label class="font-medium">Tarif de location</label>
                                                    <input type="text" value="{{ $film->rentalRate }}€" disabled 
                                                        class="w-32 bg-white dark:bg-gray-600 rounded-lg px-3 py-2 text-right text-gray-900 dark:text-gray-500">
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <label class="font-medium">Coût de remplacement</label>
                                                    <input type="text" value="{{ $film->replacementCost }}€" disabled 
                                                        class="w-32 bg-white dark:bg-gray-600 rounded-lg px-3 py-2 text-right text-gray-900 dark:text-gray-500">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($film->specialFeatures)
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6" style="border-radius: 10px;">
                                            <h4 class="text-xl font-bold mb-4 text-[#ff2d20] dark:text-[#ff2d20]">Fonctionnalités spéciales</h4>
                                            <input type="text" value="{{ $film->specialFeatures }}" disabled 
                                                class="w-full bg-white dark:bg-gray-600 rounded-lg px-3 py-2 text-gray-900 dark:text-gray-500">
                                        </div>
                                    @endif
                                   
                                </div>
                            </div>
                            <br>
                            <a href="http://localhost:8000/filmlist" class="inline-block bg-[#007bff] text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105 mr-4 float-right" style="background:  #3498DB;padding: 10px;margin: 20px;">
                                Retour à la liste des films
                            </a>
                        @else
                            <div class="text-center p-10 bg-gray-50 dark:bg-gray-700 rounded-xl" style="border-radius: 10px;">
                                <p class="text-xl text-gray-500 dark:text-gray-400">Film non trouvé</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
