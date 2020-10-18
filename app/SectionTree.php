<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionTree extends Model
{
    protected $fillable = ['content','section_number','books_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function nices()
    {
        return $this->hasMany(SectionTreeNice::class,'section_tree_id');
    }
    public function is_nice($sectionId){
        return SectionTreeNice::where('section_tree_id', $sectionId)->where('user_id',\Auth::id())->exists();
    }
    public function count_nice($sectionId){
        return SectionTreeNice::where('section_tree_id',$sectionId)->count();
    }
}
