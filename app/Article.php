<?php

namespace App;

use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Article\UrlPresenter;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Article extends Model implements HasMedia
{
    use SoftDeletes, Searchable, HasMediaTrait, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'stock', 'sub_category_id', 'status', 'website_id', 'description', 'location', 'slug'
    ];

    protected $hidden = [
        'url'
    ];

    protected $appends = [
        'image_path', 'url', 'rating'
    ];

    protected $with = ['media', 'website', 'reviews'];

    const STATUS_NOT_AVAILABLE = 'NO_DISPONIBLE';
    const STATUS_AVAILABLE = 'DISPONIBLE';
    const STATUS_PRIVATE = 'PRIVADO';

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(286)
            ->height(180);
    }

    public function getImagePathAttribute()
    {
        return !empty($this->getFirstMediaUrl('articles', 'thumb'))
            ?  $this->getFirstMediaUrl('articles', 'thumb')
            : asset('img/default.png');
    }

    public function getUrlAttribute()
    {
        return new UrlPresenter($this->website, $this);
    }

    public function getRatingAttribute()
    {
        return $this->reviews->avg('rating') ?? 0;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'shopping_cart');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @param \App\Website $website
     * @return bool
     */
    public function isRegisteredIn(Website $website)
    {
        return $this->website()->where('id', $website->id)->count() > 0;
    }

    public function toSearchableArray()
    {
        return [
            'image_path' => $this->image_path,
            'name' => $this->name,
            'website' => $this->website->name,
            'price' => $this->status !== Article::STATUS_PRIVATE ? (int) $this->price : null,
            'description' => $this->description,
            'status' => $this->status,
            'updated_at' => $this->updated_at->format('l j F Y'),
            'sub_category' => $this->subCategory->name,
            'url_path' => $this->url->show,
            'location' => $this->location != null ? $this->location : 'Sin definir',
            'rating' => (int) $this->rating
        ];
    }
}
