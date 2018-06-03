    <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    @stack('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
</head>
<body class="@yield('body-class')">
    <div id="app">
        <div class="app-banner">
            Banner informativo
            <a href="#">¡Obtenga el suyo hoy!</a>
        </div>

        <nav class="main">
            <a href="/" class="brand nav-block">
                <span>{{ $app_name }}</span>
            </a>

            <search-input></search-input>

            <ul class="main-nav">
                @include('partials.main-nav')
            </ul>

            <div class="responsive-sidebar-nav">
                <a href="#" class="toggle-slide menu-link btn-primary" style="padding: 10px 10px">&#9776;</a>
            </div>
        </nav>

        <main class="@yield('content-class', 'py-4 app-content')">
            @yield('content')
        </main>

        <footer class="main">
            <p>Tesis. Copyright &copy; Tesis.</p>
        </footer>
    </div>
</body>
</html>
