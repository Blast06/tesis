<?php

namespace App;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, SoftDeletes, HasMediaTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'avatar'
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
            ->width(46)
            ->height(46);
    }

    public function getAvatarAttribute()
    {
        return !empty($this->getFirstMediaUrl('avatars', 'thumb'))
            ? $this->getFirstMediaUrl('avatars', 'thumb')
            : asset('/img/avatar.png');
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

    public function subscribedWebsite()
    {
        return $this->belongsToMany(Website::class);
    }

    public function subscribeTo(Website $website)
    {
         $this->subscribedWebsite()->attach($website);
    }

    public function unsubscribeTo(Website $website)
    {
       $this->subscribedWebsite()->detach($website);
    }

    public function isSubscribedTo(Website $website): bool
    {
        return $this->subscribedWebsite()->where('website_id', $website->id)->count() > 0;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}