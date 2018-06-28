<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    public function article()
    {
        $this->belongsTo(Article::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
