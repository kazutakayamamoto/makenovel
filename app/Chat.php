<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['content','books_id'];

    /**
     * この投稿を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function replies()
    {
        return $this->belongsToMany(Chat::class, 'chat_reply', 'chat_id', 'reply_id')->withTimestamps();
    }

    public function repliers()
    {
        return $this->belongsToMany(Chat::class, 'chat_reply', 'reply_id', 'chat_id')->withTimestamps();
    }

    public function reply($chatId)
    {
        $this->replies()->attach($chatId);
        return true;
    }
}
