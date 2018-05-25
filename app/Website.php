<?php

namespace App;

use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Website extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = ['name', 'username', 'phone', 'address', 'private', 'domain'];

    protected $appends = [
        'image_path'
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
            ->width(286)
            ->height(180);
    }

    public function getImagePathAttribute()
    {
        return !empty($this->getFirstMediaUrl('websites', 'thumb'))
            ?  $this->getFirstMediaUrl('websites', 'thumb')
            : asset('img/default.png');
    }

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscribedUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
