@component('component.main')

    <div class="row">

        <div class="col-md-3 sidebar">
            @include('client.client-sidebar')
        </div>

        <div class="col-md-9">
            @component('component.card')

                @slot('header',  "Dashboard {$website->name}")

                @slot('header_style', 'bg-white font-weight-bold')

                # .........
            @endcomponent
        </div>

    </div>

@endcomponent