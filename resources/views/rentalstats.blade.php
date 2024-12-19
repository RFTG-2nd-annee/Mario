<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFTG - Statistiques de location</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
        <h1>RFTG - Statistiques de location</h1>
        <div class="app-section">
            <x-research-component :page="'rentalstats'" />

            <div class="rental-stats">
                <table>
                    <thead>
                        <tr>
                            <th>Film</th>
                            <th>Client</th>
                            <th>Date de location</th>
                            <th>Date de retour</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $response = file_get_contents('http://localhost:8080/toad/rental/sort');
                            $data = json_decode($response, true);
                            $rentals = $data['locations'] ?? [];

                            if(request('search')) {
                                $search = strtolower(request('search'));
                                $rentals = array_values(array_filter($rentals, function($rental) use ($search) {
                                    return str_contains(strtolower($rental['film_title']), $search) ||
                                           str_contains(strtolower($rental['customer_name']), $search);
                                }));
                            }

                            if(request('start_date') && request('end_date')) {
                                $start_date = date('Y-m-d', strtotime(request('start_date')));
                                $end_date = date('Y-m-d', strtotime(request('end_date')));
                                $rentals = array_values(array_filter($rentals, function($rental) use ($start_date, $end_date) {
                                    $rental_date = date('Y-m-d', strtotime($rental['rental_date']));
                                    $return_date = date('Y-m-d', strtotime($rental['return_date']));
                                    return $rental_date >= $start_date && $rental_date <= $end_date && $return_date <= $end_date;
                                }));
                            }

                            $sort = request('sort', 'rental_id_asc');
                            [$sort_field, $sort_direction] = explode('_', $sort);
                            
                            usort($rentals, function($a, $b) use ($sort_field, $sort_direction) {
                                $valueA = $sort_field === 'rental_date' || $sort_field === 'return_date' 
                                    ? date('Y-m-d', strtotime($a[$sort_field]))
                                    : $a[$sort_field] ?? '';
                                $valueB = $sort_field === 'rental_date' || $sort_field === 'return_date'
                                    ? date('Y-m-d', strtotime($b[$sort_field]))
                                    : $b[$sort_field] ?? '';
                                
                                return $sort_direction === 'asc' ? 
                                    strcmp($valueA, $valueB) : 
                                    strcmp($valueB, $valueA);
                            });

                            $showAll = request('showAll', false);
                            $displayData = $showAll ? $rentals : array_slice($rentals, 0, 9);
                        @endphp

                        @forelse($displayData as $rental)
                            <tr>
                                <td>{{ $rental['film_title'] }}</td>
                                <td>{{ $rental['customer_name'] }}</td>
                                <td>{{ date('d/m/Y', strtotime($rental['rental_date'])) }}</td>
                                <td>{{ date('d/m/Y', strtotime($rental['return_date'])) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: red;">Aucune location trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if(count($rentals) > 9)
                    <div style="text-align: center; margin-top: 20px;">
                        @if($showAll)
                            <a href="?{{ http_build_query(array_merge(request()->all(), ['showAll' => false])) }}" class="button">Afficher moins</a>
                        @else
                            <a href="?{{ http_build_query(array_merge(request()->all(), ['showAll' => true])) }}" class="button">Afficher plus</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
