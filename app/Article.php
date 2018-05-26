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
        'name', 'price', 'stock', 'sub_category_id', 'status', 'website_id', 'description', 'slug'
    ];

    protected $appends = [
        'image_path', 'url'
    ];

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
        return new UrlPresenter(request()->website, $this);
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

    public function scopeCategory($query)
    {
        return $query->with(['subCategory']);
    }

    public function scopeOwnsWebsite($query, Website $website)
    {
        return $query->with(['website' => function ($q) use ($website){
            $q->where('id', $website->id);
        }]);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function toSearchableArray()
    {
        return [
            'image_path' => $this->image_path,
            'name' => $this->name,
            'website' => $this->website->name,
            'price' => $this->status !== Article::STATUS_PRIVATE ? $this->price : null,
            'updated_at' => $this->updated_at->format('l j F Y'),
            'sub_category' => $this->subCategory->name,
            'slug' => $this->slug
        ];
    }
}