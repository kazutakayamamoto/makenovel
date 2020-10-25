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
    public function replies()
    {
        return $this->belongsToMany(SettingChat::class, 'chat_reply', 'chat_id', 'reply_id')->withTimestamps();
    }

    public function repliers()
    {
        return $this->belongsToMany(SettingChat::class, 'chat_reply', 'reply_id', 'chat_id')->withTimestamps();
    }

    public function reply($chatId)
    {
        $this->replies()->attach($chatId);
        return true;
    }
}
