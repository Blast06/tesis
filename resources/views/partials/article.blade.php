<div class="card shadow-sm mb-5">
   <div class="card-body">
       <div class="media">
           <img class="rounded img-fluid mr-2" src="{{ $article->image_path }}">
           <div class="media-body">
               <h5 class="mt-0">{{ $article->name }}</h5>
               <small><b>Vendedor</b> {{ $article->website->name }}</small>
               <br>
               <p class="pt-2">RD $ {{ $article->price }}</p>
               <p>
                   <i class="far fa-star"></i>
                   <i class="far fa-star"></i>
                   <i class="far fa-star"></i>
                   <i class="far fa-star"></i>
                   <i class="far fa-star"></i>
               </p>
           </div>
       </div>
   </div>
    <div class="card-footer">
        <small class="text-muted">Última actualización {{ $article->updated_at->diffForHumans() }}</small>
        <a href="#" class="card-link float-right">Ver mas</a>
    </div>
</div>