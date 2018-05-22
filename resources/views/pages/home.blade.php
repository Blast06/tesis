@component('component.main')

    <div class="row">

        <div class="d-none d-md-block col-md-3 sidebar">
            @include('partials.sidenav')
        </div>

        <div class="col-md-9 col-lg-6">

            @include('partials.alert')

            <div class="card">
                <img class="card-img-top" src="https://wallpapers.wallhaven.cc/wallpapers/full/wallhaven-634130.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Un articulo...</h5>

                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>

        </div>

        <div class="d-none d-lg-block col-lg-3 sidebar">
            {{-- Temporary, this will go on the results page--}}
            @isset(request()->q)
                @include('partials.filters')
            @endisset
        </div>

    </div>

@endcomponent