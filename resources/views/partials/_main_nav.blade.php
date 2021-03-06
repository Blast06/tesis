@guest
    <li><a href="{{ route('websites.index') }}">BUSCAR SITIOS</a></li>
    <li><a href="{{ route('login') }}">ACCEDER</a></li>
    <li><a href="{{ route('register') }}">REGISTRO</a></li>
@else
    <user-notifications :user_id="{{auth()->id()}}"></user-notifications>

    <li><a href="{{ route('messages.index') }}"><i class="fas fa-comment fa-lg"></i></a></li>

    <cart-notification :user_id="{{auth()->id()}}"></cart-notification>

    <li class="dropdown community-dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="padding: 22px 10px; !important;">
            <img class="rounded-circle" src="{{ Auth::user()->avatar }}" width="32" height="32">
            {{ Auth::user()->name }}
        </a>

        <ul class="dropdown-menu" role="menu">

            @if(auth()->user()->isAdmin())
            <li><a href="{{ route('admin.dashboard') }}">Panel admin</a></li>
            <li class="divider"></li>
            @endif
            <li><a href="{{ route('home.index') }}">Home</a></li>
            <li class="divider"></li>
            <li><a href="{{ route('websites.index') }}">Buscar Sitios</a></li>
            <li class="divider"></li>
            <li><a href="{{ url('/websites/create') }}">Crear Sitio</a></li>
            <li class="divider"></li>
            <li><a href="{{ url('/orders') }}">Mis Ordenes</a></li>
            <li class="divider"></li>
            <li><a href="{{ route('profiles.index') }}">Perfil</a></li>
            <li class="divider"></li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </li>
@endguest