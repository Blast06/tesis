<?php

namespace App\Presenters\Website;

use App\Website;

class UrlPresenter
{
    /**
     * @var \App\Website
     */
    protected $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
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
       //return route('websites.destroy', $this->website, $this->article);
    }

    public function edit()
    {
        return route('websites.edit', $this->website);
    }

    public function show()
    {
        return route('websites.show', $this->website);
    }

    public function update()
    {
        return route('websites.update', $this->website);
    }

    public function image()
    {
        return route('websites.image', $this->website);
    }

    public function subscribe()
    {
        return route('websites.subscribe', $this->website);
    }

    public function unsubscribe()
    {
        return route('websites.unsubscribe', $this->website);
    }
}