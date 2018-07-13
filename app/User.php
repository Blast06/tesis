<?php

namespace App;

use Laravel\Passport\HasApiTokens;
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
    use HasApiTokens, Notifiable, SoftDeletes, HasMediaTrait, SoftDeletes;

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

    /**
     * The attributes that should be appended in the instance of the model.
     *
     * @var array
     */
    protected $appends = [
        'avatar'
    ];

    /*
     |--------------------------------------------------------------------------
     | Mutators
     |--------------------------------------------------------------------------
     |
     | This value is formatted before being saved them in the model instances.
     |
    */

    /**
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    /*
     |--------------------------------------------------------------------------
     | Accessor
     |--------------------------------------------------------------------------
     |
     | This value is formatted when you retrieve them in the model instances.
     |
    */

    /**
     * @param $name
     * @return string
     */
    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        return !empty($this->getFirstMediaUrl('avatars', 'thumb'))
            ? $this->getFirstMediaUrl('avatars', 'thumb')
            : asset('/img/avatar.png');
    }

    /*
     |--------------------------------------------------------------------------
     | Methods
     |--------------------------------------------------------------------------
     |
     | this methods used as helpers in the instance of the user model.
     |
    */

    /**
     * @param \Spatie\MediaLibrary\Models\Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(46)
            ->height(46);
    }

    /**
     * @return string
     */
    public static function generateToken()
    {
        return str_random(64);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $foreignKey
     * @return bool
     */
    public function owns(Model $model, $foreignKey = 'user_id')
    {
        return $this->id === $model->$foreignKey;
    }

    /**
     * @return null|string
     */
    public function signedTokenUrl()
    {
        if ($this->isActive()) return null;

        return URL::temporarySignedRoute(
            'activate.account', now()->addMinutes(30), ['token' => $this->token]
        );
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return  $this->verified_at !== null;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return in_array(
            strtolower($this->email),
            array_map('strtolower', config('tesis.administrators'))
        );
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

    /*
     |--------------------------------------------------------------------------
     | Relationships
     |--------------------------------------------------------------------------
     |
     | this relationships are used to link this model with other defined models.
     |
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function websites()
    {
        return $this->hasMany(Website::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function subscribedWebsite()
    {
        return $this->morphedByMany(Website::class, 'favorites');
    }

    /**
     * @param \App\Website $website
     */
    public function subscribeTo(Website $website)
    {
         $this->subscribedWebsite()->attach($website);
    }

    /**
     * @param \App\Website $website
     */
    public function unsubscribeTo(Website $website)
    {
       $this->subscribedWebsite()->detach($website);
    }

    /**
     * @param \App\Website $website
     * @return bool
     */
    public function isSubscribedTo(Website $website): bool
    {
        return $this->subscribedWebsite()->where('favorites_id', $website->id)->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function favoriteArticle()
    {
        return $this->morphedByMany(Article::class, 'favorites');
    }

    public function favoriteTo(Article $article)
    {
        $this->favoriteArticle()->attach($article);
    }

    /**
     * @param \App\Article $article
     */
    public function unfavoriteTo(Article $article)
    {
        $this->favoriteArticle()->detach($article);
    }

    /**
     * @param \App\Article $article
     * @return bool
     */
    public function isFavoritedTo(Article $article): bool
    {
        return $this->favoriteArticle()->where('favorites_id', $article->id)->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversation()
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'shopping_cart')->withPivot('quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * @param \App\Article $article
     * @param $quantity
     */
    public function addArticleToCart(Article $article, $quantity)
    {
        try{
            $this->articles()->attach($article, ['quantity' => $quantity]);
        } catch (\Exception $exception) {
            $this->articles()->updateExistingPivot($article, ['quantity' => $quantity]);
        }

    }

    /**
     * @param \App\Article $article
     */
    public function removeArticleToCart(Article $article)
    {
        $this->articles()->detach($article);
    }

    /**
     * @param \App\Article $article
     * @return bool
     */
    public function hasNotRating(Article $article): bool
    {
        return !$this->reviews()->where('article_id', $article->id)->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
