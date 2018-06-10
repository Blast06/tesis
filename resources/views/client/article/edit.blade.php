@component('component.main')
    <div class="row">

        <div class="col-md-3 sidebar">
            @include('client._sidebar')
        </div>

        <div class="col-md-9">

            {{ Breadcrumbs::render('edit-article', $website, $article) }}

            @component('component.card')

                @slot('card_style', 'shadow-sm mb-5')

                @slot('header', "Editar ". $article->name)

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <article-update :website="{{ $website }}"
                                :article="{{ $article }}">
                </article-update>
            @endcomponent

            @component('component.card')

                @slot('header', "Imagenes ". $article->name)

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                @if($article->media->count())
                    @foreach($article->media as $media)
                        <img class="rounded" height="150" width="250" src="{{ $media->getUrl('thumb') }}" alt="{{ $media->name }}">
                    @endforeach
                @else
                    <h4>No tiene imagenes intenta agregar algunas</h4>
                @endif

            @endcomponent
        </div>
    </div>
@endcomponent

