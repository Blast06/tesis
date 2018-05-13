@component('component.main')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="jumbotron">
                <h1>Banner</h1>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="media">
                        <img src="{{ $website->image_path }}" class="rounded mr-3">
                        <div class="media-body">
                            <h3 class="mt-5">{{ $website->name }}</h3>
                            <p>1.284.696 suscriptores</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="float-right mt-5">
                        <button type="button" class="btn btn-light">SUSCRIBIRSE</button>
                        <button type="button" class="btn btn-light">Otro...</button>
                        <button type="button" class="btn btn-light">Dashboard</button>
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