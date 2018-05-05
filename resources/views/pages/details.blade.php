@component('component.main')

    <div class="row">

        <div class="col-lg-12">
            @component('component.card')

                @slot('header', 'Producto detalle.......')

                @slot('header_style', 'bg-white font-weight-bold')

                # Esto es solo un test

                @include('partials.result')

            @endcomponent
        </div>

    </div>

@endcomponent
