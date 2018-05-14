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
                            <p>1.284.696 suscriptores</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="float-right mt-5">
                        @if(auth()->check())
                            <subscribe-button
                                    subscribed="{{ auth()->user()->isSubscribedTo($website) }}"
                                    website="{{ $website->username }}">
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
                    <a class="nav-link active" href="#">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>

            @component('component.card')
                @slot('header','Header.....')

                #asdsadad asd dasdsadsa sd asdsa asdasdsdsdasdsdsddsadsadsdasdasdsdasdasdsd
                sadasdasdasdadsdsdasdsdsadasdsadsdasd sdsa dsad sadas dsfjjjrejflkjfljdfldjsfjdfjdfjl
                sd;fkdfl;d;lfkdfkl;dskf;dkf; dflkj;ljtlj;lljkl.
            @endcomponent
        </div>
    </div>
@endcomponent