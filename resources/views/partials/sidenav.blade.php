@auth
    @if($websites->count())
        <h5 class="title">Sitios De Trabajo</h5>
        <div class="list-group mb-5">
            @foreach($websites as $website)
                <a href="{{ route('client.dashboard', $website) }}" class="list">
                    <i class="fas fa-hashtag"></i>
                    {{ $website->name }}
                </a>
            @endforeach
        </div>
    @endif

    @if($subscriptions->count())
        <h5 class="title">Subscripciones</h5>
        <div class="list-group mb-5">
            @foreach($subscriptions as $subscription)
                <a href="{{ url("$subscription->username") }}" class="list">
                    <i class="fas fa-hashtag"></i>
                    {{ $subscription->name }}
                </a>
            @endforeach
        </div>
    @endif

@else
    #anucios
@endauth