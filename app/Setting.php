<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function word()
    {
        return $this->belongTo(Word::class);
    }
    public function nices()
    {
        return $this->hasMany(SettingNice::class,'setting_id');
    }
    public function is_nice($settingId){
        return SettingNice::where('setting_id', $settingId)->where('user_id',\Auth::id())->exists();
    }
}
