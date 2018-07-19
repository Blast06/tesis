<h5 class="title">Articulos</h5>
<div class="list-group mb-5">
    <a href="{{ url("/client/{$website->username}/articles/create") }}" class="list">
        <i class="far fa-circle"></i>
        Crear Articulos
    </a>
    <a href="{{ url("/client/{$website->username}/articles") }}" class="list">
        <i class="far fa-circle"></i>
        Todos los Articulos
    </a>
</div>

<h5 class="title">Mensajes</h5>
<div class="list-group mb-5">
    <a href="{{ url("/client/{$website->username}/messages") }}" class="list">
        <i class="far fa-circle"></i>
        Recibidos
    </a>
</div>

<h5 class="title">Pedidos</h5>
<div class="list-group mb-5">
    <a href="{{ url("/client/{$website->username}/orders") }}" class="list">
        <i class="far fa-circle"></i>
        Todos los pedidos
    </a>
</div>

@if($websites->count())
    <h5 class="title">Sitios De Trabajo</h5>
    <div class="list-group mb-5">
        @foreach($websites as $website)
            <a href="{{ route('client.dashboard', $website) }}" class="list">
                <img class="rounded-circle" src="{{ $website->image_path }}" width="24" height="24">
                {{ $website->name }}
            </a>
        @endforeach
    </div>
@endif

<h5 class="title">Configuraciones</h5>
<div class="list-group mb-5">
    <a href="{{ request()->website->url->edit }}" class="list">
        <i class="fas fa-cog"></i>
        Website
    </a>
</div>