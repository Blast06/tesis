<div class="card shadow-sm mb-5 d-none d-sm-block d-sm-none d-md-block">
   <div class="card-body">
       <div class="media">
           <a href="{{ $article->url->show }}">
               <img class="rounded img-fluid mr-2" src="{{ $article->image_path }}">
           </a>
           <div class="media-body">
               <h4 class="mt-0 text-uppercase">{{ $article->name }}</h4>

               <dl class="item-property">
                   <dt>Vendedor</dt>
                   <dd>
                       <div class="float-md-right">
                           @include('partials._stars')
                       </div>
                       <p>{{ $article->website->name }}</p>
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
       </div>
   </div>
    <div class="card-footer">
        <small class="text-muted">Última actualización {{ $article->updated_at->diffForHumans() }}</small>
        <strong>
            <a href="{{ $article->url->show }}" class="card-link float-right">Ver mas</a>
        </strong>
    </div>
</div>

@include('partials._article-movil')