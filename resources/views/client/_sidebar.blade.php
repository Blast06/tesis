<h5 class="title">Productos</h5>
<div class="list-group mb-5">
    <a href="{{ route('products.create', request()->website) }}" class="list">
        Crear Productos
    </a>
    <a href="" class="list">
        Todos los productos
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