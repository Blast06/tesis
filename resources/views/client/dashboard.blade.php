@component('component.main')

    <div class="row">

        <div class="col-md-3 sidebar">
            @include('client._sidebar')
        </div>

        <div class="col-md-9">

            {{ Breadcrumbs::render('dashboard', $website) }}

            @component('component.card')

                @slot('header',  "Dashboard {$website->name}")

                @slot('header_style', 'bg-white font-weight-bold')

                <div class="row">
                    <div class="card-deck col-md-12">
                        <div class="card bg-info">
                            <div class="card-body text-white text-center">
                                <h3>150</h3>
                                <p>Nuevos Pedidos</p>
                            </div>
                            <div class="card-footer text-center" style="background-color: rgba(0,0,0,.1); border-top: none; padding: 0.4rem 0.8rem;">
                                <a href="#" class="text-white">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="card bg-success">
                            <div class="card-body text-white text-center">
                                <h3> {{ $website->articles()->count() }} </h3>
                                <p>Todos Los Articulos</p>
                            </div>
                            <div class="card-footer text-center" style="background-color: rgba(0,0,0,.1); border-top: none; padding: 0.4rem 0.8rem;">
                                <a href="{{ route('articles.index', $website) }}" class="text-white">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="card bg-danger">
                            <div class="card-body text-white text-center">
                                <h3> {{ $website->user()->count() }} </h3>
                                <p>Administradores</p>
                            </div>
                            <div class="card-footer text-center" style="background-color: rgba(0,0,0,.1); border-top: none; padding: 0.4rem 0.8rem;">
                                <a href="#" class="text-white">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="card bg-warning">
                            <div class="card-body text-white text-center">
                                <h3> {{ $website->subscribedUsers()->count() }} </h3>
                                <p>Usuarios Suscriptos</p>
                            </div>
                            <div class="card-footer text-center" style="background-color: rgba(0,0,0,.1); border-top: none; padding: 0.4rem 0.8rem;">
                                <a href="#" class="text-white">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcomponent
        </div>

    </div>

@endcomponent