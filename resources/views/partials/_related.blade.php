<div class="col-md-6 mb-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <a href="{{ $article->url->show }}">
                    <img src="{{ $article->image_path }}" class="float-left mr-3" width="75" height="75">
                </a>
                <a class="text-dark" href="{{ $article->url->show }}">
                    {{ $article->name }}
                </a>
                @include('partials._stars')
                @include('partials._article_status')
            </div>
        </div>
</div>