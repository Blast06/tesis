@component('component.main')

    <div class="row">

        <div class="d-none d-md-block col-md-3 sidebar">
            @include('partials.sidenav')
        </div>

        <div class="col-md-9">

            @component('component.card')
                @slot('header', $article->name)

                <img class="" src="{{ $article->image_path }}">
                <br>
                <button>
                    Perdir articulo
                </button>
                {{ $article->price }}
                <br>
                <button>
                    Contactar Proveedor
                </button>
                {{ $article->website->name }}
                <br>
                {{ $article->description }}

            @endcomponent

        </div>
    </div>

@endcomponent