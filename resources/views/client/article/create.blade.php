@component('component.main')
    <div class="row">
        <div class="col-md-12">

            {{ Breadcrumbs::render('create-article', $website) }}

            @component('component.card')

                @slot('header','Describe tu producto, articulo o servicio')

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <product-create :website="{{ request()->website }}"></product-create>
            @endcomponent
        </div>
    </div>
@endcomponent

