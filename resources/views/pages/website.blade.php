@component('component.main')

    <div class="row justify-content-center">
        <div class="col-md-10">

            @if($websites->count())

                <div class="row">

                    @foreach($websites as $website)
                        <div class="col-sm-4">
                            <div class="card">
                                <a href="{{ url("/{$website->username}") }}">
                                    <img class="card-img-top" src="{{ $website->image_path }}" alt="{{$website->name}}">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">{{$website->name}}</h5>
                                    <p class="card-text"></p>
                                    @if(auth()->check())
                                        <subscribe-button
                                                subscribed="{{ auth()->user()->isSubscribedTo($website) }}"
                                                website="{{ $website->username }}">
                                        </subscribe-button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            @else
                <div class="alert alert-info" role="alert">
                    <h3 class="text-center">No hay resultados...</h3>
                </div>
            @endif

            {{ $websites->links() }}
        </div>
    </div>

@endcomponent