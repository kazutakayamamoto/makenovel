<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatReply extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}