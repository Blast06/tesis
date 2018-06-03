<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['conversation_id', 'user_send', 'message'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
