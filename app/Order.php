<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['price', 'status', 'quantity', 'user_id', 'article_id', 'website_id'];

    const STATUS_WAIT = 'EN ESPERA';
    const STATUS_CURRENT = 'EN PROCESO';
    const STATUS_COMPLETE = 'COMPLETADA';
    const STATUS_CANCEL = 'CANCELADA';
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}