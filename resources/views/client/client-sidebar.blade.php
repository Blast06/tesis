<h5 class="title">Mis Sitios</h5>
<div class="list-group mb-5">
    <a href="" class="list">
        Mi sitio 1
    </a>
    <a href="" class="list">
        Mi sitio 2
    </a>
    <a href="" class="list">
        Otros....
    </a>
</div>

<h5 class="title">Configuraciones</h5>
<div class="list-group mb-5">
    <a href="{{ route('client.setting.index', request()->website) }}" class="list">
        <i class="fas fa-cog"></i>
        Website
    </a>
</div>