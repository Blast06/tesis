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
        <div class="laracon-banner">
            Banner informativo
            <a href="#">¡Obtenga el suyo hoy!</a>
        </div>

        <nav class="main">
            <a href="/" class="brand nav-block">
                <span>{{ config('app.name', 'Laravel') }}</span>
            </a>

            <div class="search nav-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#A1A1A1" d="M5.8 11.7c-1.6 0-3-.6-4.1-1.7S0 7.4 0 5.8s.6-3 1.7-4.1C2.8.6 4.3 0 5.8 0s3 .6 4.1 1.7c2.3 2.3 2.3 6 0 8.3-1 1.1-2.5 1.7-4.1 1.7zM5.8 1c-1.3 0-2.5.5-3.4 1.4C1.5 3.3 1 4.5 1 5.8s.5 2.5 1.4 3.4c.9.9 2.1 1.4 3.4 1.4s2.5-.5 3.4-1.4c1.9-1.9 1.9-5 0-6.9C8.4 1.5 7.1 1 5.8 1z"></path><path fill="#A1A1A1" d="M15.5 16c-.1 0-.3 0-.3-.1L9.3 10c-.2-.2-.2-.5 0-.7s.5-.2.7 0l5.9 5.9c.2.2.2.5 0 .7-.1.1-.3.1-.4.1z"></path></svg>
                {{--<input placeholder="busqueda" type="text" id="search-input"/>--}}
                <span class="twitter-typeahead" style="position: relative; display: inline-block; direction: ltr;">
                    <input placeholder="buscar" type="text" id="search-input" class="tt-input" autocomplete="off" spellcheck="false" dir="auto" style="position: relative;vertical-align: top;">
                    <pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: &quot;Whitney SSm A&quot;, &quot;Whitney SSm B&quot;, sans-serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;"></pre>
                    <span class="tt-dropdown-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none; right: auto;">
                        <div class="tt-dataset-0"></div>
                    </span>
                </span>
            </div>

            <ul class="main-nav">
                @include('partials.main-nav')
            </ul>

            <div class="responsive-sidebar-nav">
                <a href="#" class="toggle-slide menu-link btn-primary" style="padding: 10px 10px">&#9776;</a>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="main">
            <p>Tesis. Copyright &copy; Tesis.</p>
        </footer>
    </div>
</body>
</html>
