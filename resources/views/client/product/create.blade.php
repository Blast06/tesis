@component('component.main')
    <div class="row">
        <div class="col-md-12">
            @component('component.card')

                @slot('header','Describe tu producto, articulo o servicio')

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <product-create username="{{ request()->website }}"></product-create>
            @endcomponent
        </div>
    </div>
@endcomponent

