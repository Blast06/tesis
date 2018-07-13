<?php

namespace App\Events;

use App\Article;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ArticleUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Article
     */
    public $article;

    /**
     * Create a new event instance.
     *
     * @param \App\Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }
}
