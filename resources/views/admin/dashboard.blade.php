@component('component.main')

    <div class="row">

        <div class="col-md-3 sidebar">
            @include('admin._sidebar')
        </div>

        <div class="col-md-9">
            @component('component.card')

                @slot('header',  "Dashboard Administrador")

                @slot('header_style', 'bg-white font-weight-bold')

                <div class="row">
                    <div class="card-deck col-md-12">

                        <div class="card bg-info">
                            <div class="card-body text-white text-center">
                                <h3>{{ $user_count }}</h3>
                                <p class="text-uppercase">Usuarios Registrados </p>
                            </div>
                        </div>


                        <div class="card bg-success">
                            <div class="card-body text-white text-center">
                                <h3>{{ $website_count }}</h3>
                                <p class="text-uppercase">Sitios Registrados</p>
                            </div>
                        </div>

                        <div class="card bg-danger">
                            <div class="card-body text-white text-center">
                                <h3>{{ $articles_count }}</h3>
                                <p class="text-uppercase">Articulos Registrados</p>
                            </div>
                        </div>

                        <div class="card bg-warning">
                            <div class="card-body text-white text-center">
                                <h3>{{ $categories_count }}</h3>
                                <p class="text-uppercase">Categorias Registradas</p>
                            </div>
                        </div>

                    </div>
                </div>
            @endcomponent

            @component('component.card')
                @slot('card_style', 'shadow-sm mt-5')

                @slot('header_style', 'bg-white')

                <bar-chart
                        :data="{
                    labels: {{ $chart['labels'] }},
                    datasets: [{label: 'Planes mas comprados',backgroundColor: '#1976D2',
                    data: {{ $chart['data'] }} }]
                    }"
                        :options="{responsive: true}"
                        :width="400"
                        :height="200"
                >
                </bar-chart>
            @endcomponent
        </div>

    </div>

@endcomponent