@component('component.main')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @component('component.card')

                @slot('header','Crear Sitio Web')

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <website-create></website-create>
            @endcomponent
        </div>
    </div>
@endcomponent