@component('component.main')

    <div class="row">

        <div class="d-none d-md-block col-md-3 sidebar">
            @auth
                @include('partials.sidenav')
            @else
                #Anucios
                <br>
                #Registrate
                <br>
                #Otra cosas
            @endauth

        </div>

        <div class="col-md-9 col-lg-6">

            @include('partials.alert')

            @component('component.card')

                @slot('header', 'Home')

                @slot('header_style', 'bg-white font-weight-bold')

                @include('partials.result')

            @endcomponent

        </div>

        <div class="d-none d-lg-block col-lg-3 sidebar">
            @include('partials.filters')
        </div>

    </div>

@endcomponent