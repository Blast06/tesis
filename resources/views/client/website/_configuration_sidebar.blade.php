<div class="list-group mb-5">
    <a href="{{ url("/client/{$website->username}/dashboard") }}" class="list">
        <i class="far fa-circle"></i>
        Dashboard
    </a>
</div>

<h5 class="title">Configuraciones</h5>
<div class="list-group mb-5">
    <a href="{{ route('client.websites.edit', request()->website) }}" class="list">
        <i class="fas fa-cog"></i>
        Editar Website
    </a>
</div>