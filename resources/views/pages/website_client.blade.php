@component('component.main')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="jumbotron">
                <h1>Banner</h1>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <img src="{{ $website->image_path }}" class="rounded mr-3"width="200" height="200">
                        </div>
                        <div class="col-lg-6">
                            <h3 class="mt-5">{{ $website->name }}</h3>
                            <p>{{ $website->subscribedUsers()->count() }} suscriptores</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="float-right mt-5">
                        @if(auth()->check())
                            <subscribe-button
                                    subscribed="{{ auth()->user()->isSubscribedTo($website) }}"
                                    username="{{ $website->username }}">
                            </subscribe-button>

                            <br>

                            @if(auth()->id() === $website->user_id)
                                <a href="{{ route('client.dashboard', $website) }}" class="btn btn-light">Dashboard</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Informacion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Preguntas Frecuentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contacto</a>
                </li>
            </ul>


            @if($website->articles->count())
                @each('partials.article', $website->articles, 'article')
            @else
                <div class="alert alert-info" role="alert">
                    Parece que {{ $website->name }} no tienen ninguna publicación.
                </div>
            @endif
        </div>
    </div>
@endcomponent