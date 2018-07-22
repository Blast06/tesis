<div class="card shadow-sm mb-5 d-block d-sm-none d-sm-block d-md-none">
    <a href="{{ $article->url->show }}">
        <img class="card-img-top" src="{{ $article->image_path }}">
    </a>
    <div class="card-body">
        <h5 class="card-title text-uppercase">{{ $article->name }}</h5>
        <dl class="item-property">
            <dt>Vendedor</dt>
            <dd>
                <p>{{ $article->website->name }}</p>
                @include('partials._stars')
            </dd>
        </dl>
        <p>
           <span class="price h3" style="color: #e74430;">
               <span class="currency">RD$</span>
               <span class="num">{{ number_format($article->price,2,'.',',') }}</span>
            </span>
        </p>

        @include('partials._article_status')

        <dl>
            <dt>Descripcion</dt>
            <dd><p>{{ $article->description }}</p></dd>
        </dl>
    </div>
    <div class="card-footer">
        <small class="text-muted">Última actualización {{ $article->updated_at->diffForHumans() }}</small>
        <strong>
            <a href="{{ $article->url->show }}" class="card-link float-right">Ver mas</a>
        </strong>
    </div>
</div>