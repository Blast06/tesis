@guest
    <li><a href="{{ route('websites.index') }}">SITIOS</a></li>
    <li><a href="{{ route('login') }}">ACCEDER</a></li>
    <li><a href="{{ route('register') }}">REGISTRO</a></li>
@else
    <li><a href="{{ route('home.index') }}">HOME</a></li>
    <li><a href="{{ route('websites.index') }}">SITIOS</a></li>

    <li class="dropdown community-dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="false">
            Crear
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            <li>
                <a href="{{ route('websites.create') }}">
                    <i class="fas fa-building"> Sitio</i>
                </a>
            </li>
        </ul>
    </li>

    <user-notifications :user_id="{{auth()->id()}}"></user-notifications>
    <li><a href=""><i class="fas fa-shopping-cart fa-lg"></i></a></li>

    <li class="dropdown community-dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            @if($url = Auth::user()->avatar())
                <img class="rounded-circle" src="{{ asset($url) }}">
            @endif
            {{ Auth::user()->name }}
        </a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="">Otros...</a></li>

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