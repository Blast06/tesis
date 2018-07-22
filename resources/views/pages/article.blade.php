@component('component.main')

    <div class="row">

        <div class="col-md-12">

            @component('component.card')
                @slot('header_style', 'bg-white')

                <div class="row">
                    <aside class="col-sm-5 border-right">
                        <article class="gallery-wrap">
                            <div class="img-big-wrap">
                                <div> <a href="#"><img src="{{ $article->image_path }}"></a></div>
                            </div>
                            <div class="img-small-wrap">
                                <div class="item-gallery"> <img src="{{ $article->image_path }}"> </div>
                                <div class="item-gallery"> <img src="{{ $article->image_path }}"> </div>
                                <div class="item-gallery"> <img src="{{ $article->image_path }}"> </div>
                                <div class="item-gallery"> <img src="{{ $article->image_path }}"> </div>
                            </div>
                        </article>
                    </aside>
                    <aside class="col-sm-7">
                        <article class="card-body p-5">
                            <h3 class="title mb-3">{{ $article->name }}</h3>

                            <dl class="item-property">
                                <dt>Vendedor</dt>
                                <dd>
                                    <div class="float-md-right">
                                        @include('partials._stars')
                                    </div>
                                    <a href="{{ url($article->website->username) }}"><p>{{ $article->website->name }}</p></a>
                                </dd>
                            </dl>
                            <br>

                            @if($article->status !== \App\Article::STATUS_PRIVATE)
                                <p class="price-detail-wrap">
                                    <span class="price h3" style="color: #e74430;">
                                        <span class="currency">RD$</span>
                                        <span class="num">{{ number_format($article->price,2,'.',',') }}</span>
                                    </span>
                                </p>
                            @endif



                            <dl class="item-property">
                                <dt>Description</dt>
                                <dd><p>{{ $article->description }}</p></dd>
                            </dl>

                            <dl class="param param-feature">
                                <dt>Entrega</dt>
                                <dd>{{ $article->shipping_place }}</dd>
                            </dl>

                            <hr>

                            @include('partials._article_status')

                            @if(auth()->check())
                                <shopping-button
                                    :favorited="{{ json_encode(auth()->user()->isFavoritedTo($article)) }}"
                                    :article="{{ json_encode($article) }}">
                                </shopping-button>
                            @endif
                        </article>
                    </aside>
                </div>
            @endcomponent

            @if($relateds->count())
                <div>
                    <h4 class="mt-5 text-center">Articulos relacionados</h4>
                    <div class="row">
                        @each('partials._related', $relateds, 'article')
                    </div>
                </div>
            @endif

            <article-rating
                    :is-auth="{{ json_encode(auth()->check()) }}"
                    :is-review="{{ json_encode(optional(auth()->user())->hasNotRating($article)) }}"
                    :user="{{ json_encode(auth()->user()) }}"
                    :article="{{ json_encode($article) }}"
                    :review="{{ json_encode($user_review) }}"
                    :reviews="{{ json_encode($article->reviews) }}">
            </article-rating>

        </div>
    </div>

    @slot('scripts')
        <style>
            .gallery-wrap .img-big-wrap img {
                height: 320px !important;
                width: auto;
                display: inline-block;
                cursor: zoom-in;
            }

            .gallery-wrap .img-small-wrap .item-gallery {
                width: 60px;
                height: 60px;
                //border: 1px solid #ddd;
                margin: 7px 2px;
                display: inline-block;
                overflow: hidden;
            }

            .gallery-wrap .img-small-wrap {
                text-align: center;
            }
            .gallery-wrap .img-small-wrap img {
                max-width: 100%;
                max-height: 100%;
                object-fit: cover;
                border-radius: 4px;
                cursor: zoom-in;
            }
        </style>
    @endslot
@endcomponent