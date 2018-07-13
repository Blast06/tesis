<?php

namespace App\Listeners;

use App\Article;
use App\Events\ArticleUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticleChangeStatus implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param \App\Events\ArticleUpdate $event
     * @return void
     */
    public function handle(ArticleUpdate$event)
    {
        if ($event->article->stock === 0 && $event->article->status === Article::STATUS_AVAILABLE){
            $event->article->status = Article::STATUS_NOT_AVAILABLE;
            $event->article->save();
        }
    }
}
