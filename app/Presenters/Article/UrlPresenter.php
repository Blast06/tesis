<?php

namespace App\Presenters\Article;

use App\{Website, Article};

class UrlPresenter
{
    /**
     * @var \App\Website
     */
    protected $website;

    /**
     * @var \App\Article
     */
    private $article;

    public function __construct(Website $website = null, Article $article)
    {
        $this->website = $website;
        $this->article = $article;
    }

    public function __get($key)
    {
        if(method_exists($this, $key))
        {
            return $this->$key();
        }

        return $this->$key;
    }

    public function delete()
    {
        return route('articles.destroy', [
            'website' => $this->website,
            'article' => $this->article
        ]);
    }

    public function edit()
    {
        return route('articles.edit', [
            'website' => $this->website,
            'article' => $this->article
        ]);
    }

    public function show()
    {
        return route('articles.show', $this->article->slug);
    }

    public function update()
    {
        return route('articles.update',[
            'website' => $this->website,
            'article' => $this->article
        ]);
    }
}