@component('component.main')
    <div class="row">
        <div class="col-md-12">

            {{ Breadcrumbs::render('edit-article', $website, $article) }}

            @component('component.card')

                @slot('header', "Editar ". $article->name)

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <article-update :website="{{ $website }}"
                                :article="{{ $article }}">
                </article-update>
            @endcomponent
        </div>
    </div>
@endcomponent

