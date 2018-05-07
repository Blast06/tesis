@component('component.main')

    <div class="row">

        <div class="col-md-3">

        </div>

        <div class="col-md-9">
            @component('component.card')

                @slot('header',  "Admin Dashboard")

                @slot('header_style', 'bg-white font-weight-bold')

                # .........
            @endcomponent
        </div>

    </div>

@endcomponent