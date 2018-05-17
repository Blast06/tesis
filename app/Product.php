<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'sub_category_id', 'website_id', 'description'
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
