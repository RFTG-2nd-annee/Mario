@props(['page'])

<div class="controls" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
    @if($page === 'rentalstats')
        <a href="/filmlist" class="button" style="white-space: nowrap;">Retour</a>
    @endif

    <form method="GET" action="" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; flex: 1;" @if($page === 'filmlist') onsubmit="return validateDates()" @endif>
        @php
            $isFilmList = $page === 'filmlist';
            $defaultSort = $isFilmList ? 'title_asc' : 'rental_date_desc';
            $currentSort = request('sort', $defaultSort);
            $searchValue = request('search');
        @endphp

        <div class="search-container" style="min-width: 200px; flex: 1;">
            <input type="text" 
                   name="search" 
                   class="search-bar" 
                   placeholder="{{ $isFilmList ? 'Rechercher un titre...' : 'Rechercher un film ou un client...' }}" 
                   value="{{ $searchValue }}" 
                   style="width: 100%;">
            @if($searchValue)
                <span class="clear-search" onclick="window.location.href='?sort={{ $currentSort }}{{ $isFilmList ? '&start_year='.request('start_year', '2006').'&end_year='.request('end_year', date('Y')) : '' }}'">✕</span>
            @endif
        </div>

        <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
            @if($isFilmList)
                @php
                    $currentYear = date('Y');
                    $startYear = request('start_year', '2006');
                    $endYear = request('end_year', $currentYear);
                @endphp
                <input type="number" 
                       id="start_year" 
                       name="start_year" 
                       min="1900" 
                       max="{{ $currentYear }}" 
                       value="{{ $startYear }}" 
                       title="Année de début" 
                       placeholder="Année début">
                <span>→</span>
                <input type="number" 
                       id="end_year" 
                       name="end_year" 
                       min="1900" 
                       max="{{ $currentYear }}" 
                       value="{{ $endYear }}" 
                       title="Année de fin" 
                       placeholder="Année fin">
            @else
                @php 
                    $response = file_get_contents('http://localhost:8080/toad/rental/sort');
                    $data = json_decode($response, true);
                    $rentals = $data['locations'] ?? [];
                    
                    $minDate = date('Y-m-d');
                    $maxDate = date('Y-m-d');
                    
                    if (!empty($rentals)) {
                        $dates = array_map(function($rental) {
                            return date('Y-m-d', strtotime($rental['rental_date']));
                        }, $rentals);
                        $minDate = min($dates);
                        $maxDate = max($dates);
                    }
                    
                    $start_date = request('start_date', $minDate);
                    $end_date = request('end_date', $maxDate);
                @endphp
                <input type="date" 
                       id="start_date" 
                       name="start_date" 
                       value="{{ $start_date }}" 
                       title="Date de début">
                <span>→</span>
                <input type="date" 
                       id="end_date" 
                       name="end_date" 
                       value="{{ $end_date }}" 
                       title="Date de fin">
            @endif
            <button type="submit" class="button" style="white-space: nowrap;">Rechercher</button>
        </div>

        {{-- Menu déroulant pour le tri (temporairement désactivé)
        <select name="sort" onchange="this.form.submit()" class="sort-select" style="min-width: 150px; display: none;">
            @if($isFilmList)
                @php
                    $sortOptions = [
                        'title_asc' => 'Titre (A-Z)',
                        'title_desc' => 'Titre (Z-A)',
                        'year_asc' => 'Année (Croissant)',
                        'year_desc' => 'Année (Décroissant)',
                        'duration_asc' => 'Durée (Croissant)',
                        'duration_desc' => 'Durée (Décroissant)'
                    ];
                @endphp
                @foreach($sortOptions as $value => $label)
                    <option value="{{ $value }}" {{ $currentSort == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            @else
                @php
                    $sortOptions = [
                        'rental_date_desc' => 'Locations récentes',
                        'rental_date_asc' => 'Locations anciennes',
                        'return_date_desc' => 'Retours récents',
                        'return_date_asc' => 'Retours anciens',
                        'film_title_asc' => 'Film (A-Z)',
                        'film_title_desc' => 'Film (Z-A)',
                        'customer_name_asc' => 'Client (A-Z)',
                        'customer_name_desc' => 'Client (Z-A)'
                    ];
                @endphp
                @foreach($sortOptions as $value => $label)
                    <option value="{{ $value }}" {{ $currentSort == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            @endif
        </select>
        --}}
    </form>
</div>

@if($isFilmList)
    <script>
    function validateDates() {
        const startYear = parseInt(document.getElementById('start_year').value);
        const endYear = parseInt(document.getElementById('end_year').value);
        
        if(startYear > endYear) {
            alert("L'année de début ne peut pas être supérieure à l'année de fin");
            return false;
        }
        return true;
    }
    </script>
@endif
