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
}
