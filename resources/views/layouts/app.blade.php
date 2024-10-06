<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Города')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        .cities-container {
            display: flex; /* Use flexbox for layout */
            flex-wrap: wrap; /* Allow wrapping to new lines */
            margin: -5px; /* Adjust negative margin to offset column spacing */
        }

        .city-column {
            width: calc(20% - 10px); /* Four columns with some space between */
            max-width: 500px; /* Max width of 500 pixels */
            box-sizing: border-box; /* Include padding/margins in the width */
            margin: 5px; /* Optional margin between columns */
            list-style-type: none; /* Remove default list styling */
            padding: 0; /* Remove default padding */
        }

        .pagination{
            margin-top: 30px;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">Главная</a>
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <a class="nav-link" href="{{ session('selected_city_name') ? "/".session('selected_city')."/about" : route('about') }}">
                        О нас
                    </a>
                    <a class="nav-link" href="{{ session('selected_city_name') ? "/".session('selected_city')."/news" : route('news') }}">
                        Новости
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <h2 class="text-center">
        Текущий:
        @if(session('selected_city_name'))
            <span class="font-weight-bold">{{ ucfirst(session('selected_city_name')) }}</span>
        @else
            <span class="text-muted">Не выбран</span>
        @endif
    </h2>
</header>

<main>
    @yield('content')
</main>


</body>
</html>
