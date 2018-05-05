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
                <svg xmlns="http://www.w3.org/2000/svg" width="84.1" height="57.6" viewBox="0 0 84.1 57.6"><path fill="#FB503B" d="M83.8 26.9c-.6-.6-8.3-10.3-9.6-11.9-1.4-1.6-2-1.3-2.9-1.2s-10.6 1.8-11.7 1.9c-1.1.2-1.8.6-1.1 1.6.6.9 7 9.9 8.4 12l-25.5 6.1L21.2 1.5c-.8-1.2-1-1.6-2.8-1.5C16.6.1 2.5 1.3 1.5 1.3c-1 .1-2.1.5-1.1 2.9S17.4 41 17.8 42c.4 1 1.6 2.6 4.3 2 2.8-.7 12.4-3.2 17.7-4.6 2.8 5 8.4 15.2 9.5 16.7 1.4 2 2.4 1.6 4.5 1 1.7-.5 26.2-9.3 27.3-9.8 1.1-.5 1.8-.8 1-1.9-.6-.8-7-9.5-10.4-14 2.3-.6 10.6-2.8 11.5-3.1 1-.3 1.2-.8.6-1.4zm-46.3 9.5c-.3.1-14.6 3.5-15.3 3.7-.8.2-.8.1-.8-.2-.2-.3-17-35.1-17.3-35.5-.2-.4-.2-.8 0-.8S17.6 2.4 18 2.4c.5 0 .4.1.6.4 0 0 18.7 32.3 19 32.8.4.5.2.7-.1.8zm40.2 7.5c.2.4.5.6-.3.8-.7.3-24.1 8.2-24.6 8.4-.5.2-.8.3-1.4-.6s-8.2-14-8.2-14L68.1 32c.6-.2.8-.3 1.2.3.4.7 8.2 11.3 8.4 11.6zm1.6-17.6c-.6.1-9.7 2.4-9.7 2.4l-7.5-10.2c-.2-.3-.4-.6.1-.7.5-.1 9-1.6 9.4-1.7.4-.1.7-.2 1.2.5.5.6 6.9 8.8 7.2 9.1.3.3-.1.5-.7.6z"></path></svg>
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
