@component('component.main')
    @slot('content_class', 'app-content')

    <div class="row justify-content-center">

        <div class="col-md-10">

            <div class="jumbotron mb-0" style="
            background: url('{{ $website->banner_path  }}');
            no-repeat: center;
            -webkit-background-size: 100% 100%;
            -moz-background-size: 100% 100%;
            -o-background-size: 100% 100%;
            background-size: 100% 100%;
            border-radius: 0;
            height: 240px">
            </div>

            @component('component.card')
                @slot('card_style', 'mt-0 mb-5 shadow-sm    ')

                @slot('header_style', 'd-none')

                <div class="row">

                    <div class="col-md-3">
                        <img src="{{ $website->image_path }}" class="img-thumbnail rounded mx-auto d-block" width="200" height="200">
                    </div>

                    <div class="col-md-6 text-center">
                        <h3 class="mt-5">
                            {{ $website->name }}
                            <br>
                            <small class="text-muted">{{ $website->subscribed_users_count }} suscriptores</small>
                        </h3>

                        @isset($website->description)
                        <p>{{ $website->description }}</p>
                        @endisset
                    </div>

                    <div class="col-md-3">
                        <div class="mt-5 text-center">
                            @if(auth()->check())
                                <subscribe-button
                                        subscribed="{{ auth()->user()->isSubscribedTo($website) }}"
                                        username="{{ $website->username }}">
                                </subscribe-button>

                                <br>

                                @if(auth()->id() === $website->user_id)
                                    <a href="{{ route('client.dashboard', $website) }}" class="btn btn-light text-uppercase">Dashboard</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('websites.information', $website) }}">
                            Informacion
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/messages/create') }}">
                            Contactar
                            <i class="far fa-envelope"></i>
                        </a>
                    </li>
                </ul>
            @endcomponent

            <form action="{{ $website->url->show }}">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Buscar articulos de {{ $website->name }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">Buscar articulos</button>
                    </div>
                </div>
            </form>

            @if($website->articles->count())
                @each('partials._article', $website->articles, 'article')
            @else
                @if(request('search'))
                    <div class="alert alert-info" role="alert">
                        No hay resultados para la busqueda de  {{ request('search') }}.
                    </div>
                    @else
                    <div class="alert alert-info" role="alert">
                        Parece que {{ $website->name }} no tienen ninguna publicación.
                    </div>
                @endif
            @endif
        </div>
    </div>
@endcomponent