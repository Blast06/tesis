<dl>
    <dt>Estado</dt>
    @php
        $badge = [
         \App\Article::STATUS_AVAILABLE => 'badge-success',
         \App\Article::STATUS_NOT_AVAILABLE => 'badge-danger',
         \App\Article::STATUS_PRIVATE => 'badge-info'];
    @endphp
    <dd><span class="badge {{ $badge[$article->status] }}">{{ $article->status }}</span></dd>
</dl>