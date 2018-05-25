@component('component.main')
    <div class="row">
        <div class="col-md-3 sidebar">
            @include('client.website._configuration_sidebar')
        </div>

        <div class="col-md-9">

            {{ Breadcrumbs::render('website_config', $website) }}

            @include('partials.alert')

            @component('component.card')

                @slot('header',"Editar {$website->name}")

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <website-update :website="{{ $website }}"></website-update>

            @endcomponent
        </div>
    </div>
@endcomponent
