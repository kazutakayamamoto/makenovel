<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingNice extends Model
{
    protected $fillable=['setting_id','user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function setting(){
        return $this->belongsTo(Setting::class);
    }
}
