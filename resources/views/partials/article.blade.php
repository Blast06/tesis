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
                           <div class="stars">
                               <span class="fa fa-star text-warning"></span>
                               <span class="fa fa-star text-warning"></span>
                               <span class="fa fa-star text-warning"></span>
                               <span class="fa fa-star text-warning"></span>
                               <span class="fa fa-star"></span>
                           </div>
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

               <dl>
                   <dt>Estado</dt>
                   @php
                   $badge = [
                    \App\Article::STATUS_AVAILABLE => 'badge-success',
                    \App\Article::STATUS_NOT_AVAILABLE => 'badge-danger',
                    \App\Article::STATUS_PRIVATE => 'badge-info'];
                   @endphp
                   <dd><span class="badge {{ $badge[$article->status] }}">{{ $article->status }}</span></dd>
               </dl>

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
                <div class="stars">
                    <span class="fa fa-star text-warning"></span>
                    <span class="fa fa-star text-warning"></span>
                    <span class="fa fa-star text-warning"></span>
                    <span class="fa fa-star text-warning"></span>
                    <span class="fa fa-star"></span>
                </div>
            </dd>
        </dl>
        <p>
           <span class="price h3" style="color: #e74430;">
                <span class="currency">RD$</span>
                <span class="num">{{ $article->price }}</span>
            </span>
        </p>

        <dl>
            <dt>Estado</dt>
            @php
                $badge = [
                 \App\Article::STATUS_AVAILABLE => 'badge-success',
                 \App\Article::STATUS_NOT_AVAILABLE => 'badge-danger',
                 \App\Article::STATUS_PRIVATE => 'badge-info'];
            @endphp
            <dd><span class="badge {{ $badge[$article->status] }}">{{ $article->status }}</span></dd>
        </dl>

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