<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['content','section_number'];

    /**
     * この投稿を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nices()
    {
        return $this->hasMany(Nice::class,'section_id');
    }
    public function is_nice($sectionId){
        return Nice::where('section_id', $sectionId)->where('user_id',\Auth::id())->exists();
    }
    public function count_nice($sectionId){
        return Nice::where('section_id',$sectionId)->count();
    }
}
