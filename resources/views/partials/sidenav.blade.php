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
    <h5 class="title">Subscripciones</h5>
    <div class="list-group mb-5">
        <a href="#" class="list">
            <i class="fas fa-hashtag"></i>
            Dapibus ac facilisis in
        </a>

        <a href="#" class="list">
            <i class="fas fa-hashtag"></i>
            Dapibus ac facilisis in
        </a>

        <a href="#" class="list">
            <i class="fas fa-hashtag"></i>
            Dapibus ac facilisis in
        </a>
    </div>
    @else
    #anucios
@endauth