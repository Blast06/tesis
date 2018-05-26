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

    public function __construct(Website $website, Article $article)
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
        return route('articles.destroy', $this->website, $this->article);
    }

    public function edit()
    {
        return route('articles.edit', $this->website, $this->article);
    }

    public function show()
    {
        return route('articles.show', $this->website, $this->article);
    }

    public function update()
    {
        return route('articles.update', $this->website, $this->article);
    }
}