<?php

namespace App;

use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Product extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'stock', 'sub_category_id', 'status', 'website_id', 'description'
    ];

    protected $appends = [
        'image_path'
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
        return !empty($this->getFirstMediaUrl('products', 'thumb'))
            ?  $this->getFirstMediaUrl('products', 'thumb')
            : asset('img/default.png');
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
}
