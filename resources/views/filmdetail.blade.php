<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFTG - Détails du Film</title>
    <style>
        /* Réinitialisation et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --background-color: #f0f4f8;
            --text-color: #2d3748;
            --app-background: #ffffff;
            --app-shadow: rgba(0,0,0,0.1);
            --input-border: #cbd5e0;
            --button-bg: #4299e1;
            --button-text: white;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.8;
            transition: all 0.5s ease;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        h1 {
            color: var(--text-color);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 3em;
        }

        .film-detail {
            background-color: var(--app-background);
            border-radius: 20px;
            padding: 50px;
            margin-bottom: 60px;
            box-shadow: 0 15px 35px var(--app-shadow);
        }

        .film-title {
            font-size: 2.5em;
            color: var(--button-bg);
            text-align: center;
            margin-bottom: 20px;
        }

        .info-section {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .info-section h4 {
            color: var(--button-bg);
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 2px solid var(--input-border);
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .button {
            background-color: var(--button-bg);
            color: var(--button-text);
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ __("Détails du film") }}</h1>

        <div class="film-detail">
            @php
                $filmId = request()->get('id');
                $response = file_get_contents("http://localhost:8080/toad/film/getById?id={$filmId}");
                $film = json_decode($response);
            @endphp

            @if(isset($film))
                <div class="info-section">
                    <h4 class="film-title">{{ $film->title }}</h4>
                    <input type="text" value="{{ $film->description }}" disabled>
                </div>

                <div class="info-section">
                    <h4>Informations générales</h4>
                    <div>
                        <label>Année de sortie:</label>
                        <input type="text" value="{{ $film->releaseYear }}" disabled>
                    </div>
                    <div>
                        <label>Durée:</label>
                        <input type="text" value="{{ $film->length }} minutes" disabled>
                    </div>
                    <div>
                        <label>Classification:</label>
                        <input type="text" value="{{ $film->rating }}" disabled>
                    </div>
                </div>

                <div class="info-section">
                    <h4>Informations de location</h4>
                    <div>
                        <label>Durée de location:</label>
                        <input type="text" value="{{ $film->rentalDuration }} jours" disabled>
                    </div>
                    <div>
                        <label>Tarif de location:</label>
                        <input type="text" value="{{ $film->rentalRate }}€" disabled>
                    </div>
                    <div>
                        <label>Coût de remplacement:</label>
                        <input type="text" value="{{ $film->replacementCost }}€" disabled>
                    </div>
                </div>

                @if($film->specialFeatures)
                    <div class="info-section">
                        <h4>Fonctionnalités spéciales</h4>
                        <input type="text" value="{{ $film->specialFeatures }}" disabled>
                    </div>
                @endif

                <a href="http://localhost:8000/filmlist" class="button">Retour à la liste des films</a>
            @else
                <div class="text-center">
                    <p>Film non trouvé</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
