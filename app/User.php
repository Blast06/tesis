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
        'name', 'email', 'password', 'token', 'verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token'
    ];

    protected $appends = [
        'avatar'
    ];

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
            'activate.account', now()->addMinutes(30), ['token' => $this->token]
        );
    }

    public function isActive()
    {
        return  $this->verified_at !== null;
    }

    public function isAdmin()
    {
        return in_array(
            strtolower($this->email),
            array_map('strtolower', config('tesis.administrators'))
        );
    }

    // Relationships

    public function websites()
    {
        return $this->hasMany(Website::class);
    }

    public function subscribedWebsite()
    {
        return $this->morphedByMany(Website::class, 'favorites');
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
        return $this->subscribedWebsite()->where('favorites_id', $website->id)->count() > 0;
    }

    public function favoriteArticle()
    {
        return $this->morphedByMany(Article::class, 'favorites');
    }

    public function favoriteTo(Article $article)
    {
        $this->favoriteArticle()->attach($article);
    }

    public function unfavoriteTo(Article $article)
    {
        $this->favoriteArticle()->detach($article);
    }

    public function isFavoritedTo(Article $article): bool
    {
        return $this->favoriteArticle()->where('favorites_id', $article->id)->count() > 0;
    }

    public function conversation()
    {
        return $this->hasMany(Conversation::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'shopping_cart')->withPivot('quantity');
    }

    public function reviews()
    {
        return $this->hasMany(User::class);
    }

    public function addArticleToCart(Article $article, $quantity)
    {
        try{
            $this->articles()->attach($article, ['quantity' => $quantity]);
        } catch (\Exception $exception) {
            $this->articles()->updateExistingPivot($article, ['quantity' => $quantity]);
        }

    }

    public function removeArticleToCart(Article $article)
    {
        $this->articles()->detach($article);
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
