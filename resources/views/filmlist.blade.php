<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des films') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <br>
                    <br>
                    <h1 class="text-3xl font-bold mb-12 text-[#ff2d20] dark:text-[#ff2d20] text-center mx-auto my-8">{{ __("Voici la liste des films disponibles.") }}</h1>
                    <br>

                    <br>

                    <div class="overflow-x-auto mx-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="margin: 20px;">
                            @php
                                $currentPage = request()->get('page', 1);
                                $perPage = 9; // Changé à 9 pour un meilleur affichage en grille
                                $response = file_get_contents('http://localhost:8080/toad/film/all');
                                $films = json_decode($response);
                                $totalFilms = count($films);
                                $totalPages = ceil($totalFilms / $perPage);
                                $films = array_slice($films, ($currentPage - 1) * $perPage, $perPage);
                            @endphp
                            @if(isset($films) && count($films) > 0)
                                @foreach ($films as $film)
                                    <a href="{{ url('/filmdetail?id=' . $film->filmId) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1 cursor-pointer">
                                        <div class="p-6">
                                            <h3 class="text-xl font-bold text-[#ff2d20] dark:text-[#ff2d20] mb-2">{{ $film->title }}</h3>
                                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">ID: {{ $film->filmId }}</div>
                                            <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">{{ $film->description }}</p>
                                            <div class="grid grid-cols-2 gap-4 text-sm">
                                                <div>
                                                    <span class="font-semibold">Année:</span>
                                                    <span class="text-gray-600 dark:text-gray-400">{{ $film->releaseYear }}</span>
                                                </div>
                                                <div>
                                                    <span class="font-semibold">Durée location:</span>
                                                    <span class="text-gray-600 dark:text-gray-400">{{ $film->rentalDuration }} jours</span>
                                                </div>
                                                <div>
                                                    <span class="font-semibold">Tarif:</span>
                                                    <span class="text-gray-600 dark:text-gray-400">{{ $film->rentalRate }}€</span>
                                                </div>
                                                <div>
                                                    <span class="font-semibold">Évaluation:</span>
                                                    <span class="text-gray-600 dark:text-gray-400">{{ $film->rating }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="col-span-3 text-center text-gray-500 dark:text-gray-400 py-8">
                                    Aucun film disponible
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <nav class="relative z-0 inline-flex shadow-sm rounded-md">
                            @if($currentPage > 1)
                            <a href="?page=1" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                &lt;&lt;
                            </a>
                            <a href="?page={{ $currentPage - 1 }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                &lt;
                            </a>
                            @endif

                            @php
                                $start = max(1, min($currentPage - 2, $totalPages - 4));
                                $end = min($totalPages, max(5, $currentPage + 2));
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                <a href="?page={{ $i }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 {{ $i == $currentPage ? 'bg-[#ff2d20] text-white border-[#ff2d20]' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600' }} text-sm font-medium transition ease-in-out duration-150">
                                    {{ $i }}
                                </a>
                            @endfor

                            @if($end < $totalPages)
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200">...</span>
                            @endif

                            @if($currentPage < $totalPages)
                            <a href="?page={{ $currentPage + 1 }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                &gt;
                            </a>
                            <a href="?page={{ $totalPages }}" class="relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                &gt;&gt;
                            </a>
                            @endif
                        </nav>
                    </div>
                    <br>

                    <br>

                    <br>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
