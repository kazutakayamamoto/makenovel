<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingChat extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function word(){
        return $this->belongsTo(Word::class);
    }
    public function replies(){
        return $this->hasMany(SettingChatReply::class);
    }
}
