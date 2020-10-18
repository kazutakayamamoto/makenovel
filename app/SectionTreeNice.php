<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionTreeNice extends Model
{
    protected $fillable=['user_id','section_tree_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function section_tree(){
        return $this->belongsTo(SectionTree::class);
    }
}
