@component('component.main')
    <div class="row">

        <div class="col-md-3 sidebar">
            @include('client._sidebar')
        </div>

        <div class="col-md-9">

            @include('partials.alert')

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
                    <div class="row">
                        @foreach($article->media as $media)
                            <div class="col-md-4">
                                <div class="card bg-dark mb-2">
                                    <img class="card-img" height="150" width="250" src="{{ $media->getUrl('thumb') }}" alt="{{ $media->name }}">
                                    <div class="card-img-overlay">
                                        <h5 class="card-title">
                                            <a class="text-white" style="background-color:rgba(0, 0, 0, 0.5); padding: 5px 5px 5px 5px"
                                               onclick="event.preventDefault();
                                                       document.getElementById('{{ 'media-delete-'. $media->id  }}').submit();">
                                                <i class="fas fa-trash"></i>
                                                Eliminar
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                                <form id="media-delete-{{ $media->id }}"
                                      action="{{ url("client/{$website->username}/medias/{$media->id}") }}"
                                      method="POST" style="display: none;">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        <strong>{{ $article->name }}</strong>
                        No tiene ninguna imagen intenta agregar algunas.
                    </div>
                @endif

            @endcomponent
        </div>
    </div>
@endcomponent

