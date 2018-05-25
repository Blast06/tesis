@component('component.main')

    <div class="row">

        <div class="col-lg-12">
            @component('component.card')

                @slot('header', 'Producto Busqueda.......')

                @slot('header_style', 'bg-white font-weight-bold')

                # Esto es solo un test



            @endcomponent
        </div>

    </div>

@endcomponent
