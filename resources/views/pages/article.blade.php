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
                <a class="btn btn-info btn-sm" @click="$modal.show('send-message')">
                    Contactar Proveedor
                </a>
                {{ $article->website->name }}
                <br>
                {{ $article->description }}

            @endcomponent

        </div>
    </div>

@endcomponent