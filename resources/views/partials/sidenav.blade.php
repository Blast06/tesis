@guest
    ads
@else
    @if($websites->count())
        <h5 class="title">Sitios De Trabajo</h5>
        <div class="list-group mb-5">
            @foreach($websites as $website)
                <a href="{{ route('client.dashboard', $website) }}" class="list">
                    <img class="rounded-circle" src="{{ $website->image_path }}" width="24" height="24">
                    {{ str_limit($website->name, 20, '...') }}
                </a>
            @endforeach
        </div>
    @endif

    @if($subscriptions->count())
        <h5 class="title"><a href="{{ route('websites.feed') }}">Subscripciones</a></h5>
        <div class="list-group mb-5">
            @foreach($subscriptions as $subscription)
                <a href="{{ url("$subscription->username") }}" class="list">
                    <img class="rounded-circle" src="{{ $subscription->image_path }}" width="24" height="24">
                    {{ str_limit($subscription->name, 20, '..') }}
                </a>
            @endforeach
        </div>
    @endif
@endguest