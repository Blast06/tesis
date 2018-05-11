@component('component.main')

    <div class="row justify-content-center">
        <div class="col-md-8">

            @if($websites->count())

                @foreach($websites as $website)
                    <a style="text-align: center" href="{{ url("/{$website->username}") }}">
                        <h4>{{$website->name}}</h4>
                    </a>
                @endforeach

            @else
                <div class="alert alert-info" role="alert">
                    <h3 class="text-center">No hay resultados...</h3>
                </div>
            @endif

            {{ $websites->links() }}
        </div>
    </div>

@endcomponent