<h5 class="title">Articulos</h5>
<div class="list-group mb-5">
    <a href="{{ route('articles.create', request()->website) }}" class="list">
        Crear Articulos
    </a>
    <a href="{{ route('articles.index', request()->website) }}" class="list">
        Todos los Articulos
    </a>
</div>

@if($websites->count())
    <h5 class="title">Sitios De Trabajo</h5>
    <div class="list-group mb-5">
        @foreach($websites as $website)
            <a href="{{ route('client.dashboard', $website) }}" class="list">

                {{ $website->name }}
            </a>
        @endforeach
    </div>
@endif

<h5 class="title">Configuraciones</h5>
<div class="list-group mb-5">
    <a href="{{ route('websites.edit', request()->website) }}" class="list">
        <i class="fas fa-cog"></i>
        Website
    </a>
</div>