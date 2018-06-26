<?php

namespace App;

use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Website\UrlPresenter;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Website extends Model implements HasMedia
{
    use SoftDeletes, Searchable, HasMediaTrait;

    protected $fillable = [
        'name', 'username', 'description', 'phone', 'address', 'private', 'domain'
    ];

    protected $hidden = [
        'url'
    ];

    protected $appends = [
        'image_path', 'banner_path', 'url'
    ];

    // Mutators

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setUsernameAttribute($username)
    {
        $this->attributes['username'] = strtolower($username);
    }

    // Accessor

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getUrlAttribute()
    {
        return new UrlPresenter($this);
    }

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(268)
            ->height(184);
    }

    public function getImagePathAttribute()
    {
        return !empty($this->getFirstMediaUrl('websites', 'thumb'))
            ?  $this->getFirstMediaUrl('websites', 'thumb')
            : asset('img/website.png');
    }

    public function getBannerPathAttribute()
    {
        return !empty($this->getFirstMediaUrl('websites_banner', 'thumb'))
            ?  $this->getFirstMediaUrl('websites_banner', 'thumb')
            : asset('img/banner.png');
    }

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscribedUsers()
    {
        return $this->morphToMany(User::class, 'favorites');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function conversation()
    {
        return $this->hasMany(Conversation::class);
    }

    public function toSearchableArray()
    {
        return [
            'image_path' => $this->image_path,
            'name' => $this->name,
            'username' => $this->username,
            'created_at' => $this->created_at->format('F Y'),
            'url_path' => $this->url->show
        ];
    }
}
