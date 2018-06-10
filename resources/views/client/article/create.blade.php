@component('component.main')
    <div class="row">

        <div class="col-md-3 sidebar">
            @include('client._sidebar')
        </div>

        <div class="col-md-9">

            {{ Breadcrumbs::render('create-article', $website) }}

            @component('component.card')

                @slot('header','Describeles a todos lo que les ofreces')

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <article-create :website="{{ request()->website }}"></article-create>
            @endcomponent
        </div>
    </div>
@endcomponent

