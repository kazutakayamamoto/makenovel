<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = ['name'];
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
    public function setting_chats()
    {
        return $this->hasMany(SettingChat::class);
    }
    
}
