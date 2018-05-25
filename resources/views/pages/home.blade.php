@component('component.main')

    <div class="row">

        <div class="d-none d-md-block col-md-3 sidebar">
            @include('partials.sidenav')
        </div>

        <div class="col-md-9">

            @include('partials.alert')

            @if($articles->count())
                @each('partials.article', $articles, 'article')
            @endif

        </div>
    </div>

@endcomponent