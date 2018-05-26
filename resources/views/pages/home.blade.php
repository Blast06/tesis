@component('component.main')

    <div class="row">

        <div class="d-none d-md-block col-md-3 sidebar">
            @include('partials.sidenav')
        </div>

        <div class="col-md-9">

            @include('partials.alert')

            @if($articles->count())
                @each('partials.article', $articles, 'article')
            @else
                <div class="alert alert-info" role="alert">
                    Parece que los sitios que sigue no tienen ninguna publicación o no sigues a ningun sitio.
                    <br>
                    Haga clic en el enlace <b><a href="{{ url('/websites') }}">Buscar sitios</a></b> para encontrar el sitio de su preferencia.
                </div>
            @endif

        </div>
    </div>

@endcomponent