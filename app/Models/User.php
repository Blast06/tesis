<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, SoftDeletes, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    // Mutators
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    // Accessor
    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public static function generateToken()
    {
        return str_random(64);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(32)
            ->height(32);
    }

    public function avatar()
    {
        $path = optional($this->getMedia('avatars')->first())->getUrl('thumb');

        if ($path) {
            return config('app.url') . $path;
        }

        return false;
    }

    public function owns(Model $model, $foreignKey = 'user_id')
    {
        return $this->id === $model->$foreignKey;
    }

    public function signedTokenUrl()
    {
        if ($this->isActive()) return null;

        return URL::temporarySignedRoute(
            'account.activate', now()->addMinutes(30), ['token' => $this->token]
        );
    }

    public function isActive()
    {
        return  $this->verified_at !== null;
    }

    public function isAdmin()
    {
        return $this->role === User::ROLE_ADMIN;
    }

    // Relationships

    public function websites()
    {
        return $this->hasMany(Website::class);
    }

}
