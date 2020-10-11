<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable = ['title','subject','section_nice_number','setting_nice_number'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function words()
    {
        return $this->hasMany(Word::class);
    }
}
