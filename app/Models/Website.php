<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'private', 'domain'];

    // Mutators

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    // Accessor

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    // Relationships

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
