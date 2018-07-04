@component('component.main')

    <div class="row">

        <div class="col-md-3">

        </div>

        <div class="col-md-9">
            @component('component.card')

                @slot('header',  "Admin Dashboard")

                @slot('header_style', 'bg-white font-weight-bold')

                <div class="row">
                    <div class="card-deck col-md-12">

                        <div class="card bg-info">
                            <div class="card-body text-white text-center">
                                <h3>{{ $website_private_count }}</h3>
                                <p class="text-uppercase">Sitios Registrados <b>(PREMIUM)</b></p>
                            </div>
                            <div class="card-footer text-center" style="background-color: rgba(0,0,0,.1); border-top: none; padding: 0.4rem 0.8rem;">
                                <a href="#" class="text-white">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>


                        <div class="card bg-success">
                            <div class="card-body text-white text-center">
                                <h3>{{ $website_non_private_count }}</h3>
                                <p class="text-uppercase">Sitios Registrados <b>(NO PREMIUM)</b></p>
                            </div>
                            <div class="card-footer text-center" style="background-color: rgba(0,0,0,.1); border-top: none; padding: 0.4rem 0.8rem;">
                                <a href="#" class="text-white">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="card bg-danger">
                            <div class="card-body text-white text-center">
                                <h3>{{ $articles_count }}</h3>
                                <p class="text-uppercase">Articulos Registrados</p>
                            </div>
                            <div class="card-footer text-center" style="background-color: rgba(0,0,0,.1); border-top: none; padding: 0.4rem 0.8rem;">
                                <a href="#" class="text-white">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="card bg-warning">
                            <div class="card-body text-white text-center">
                                <h3>{{ $categories_count }}</h3>
                                <p class="text-uppercase">Categorias Registradas</p>
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