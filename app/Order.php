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

    /**
     * @param \App\Website $website
     * @return bool
     */
    public function isRegisteredIn(Website $website)
    {
        return $this->website()->where('id', $website->id)->count() > 0;
    }

    public function subtotal()
    {
        if (is_null($this->price)) {
            return 0;
        }

        return $this->price * $this->quantity;
    }

    public function iva()
    {
        return $this->subtotal() * 0.18;
    }

    public function total()
    {
        return $this->subtotal() + $this->iva();
    }
}
