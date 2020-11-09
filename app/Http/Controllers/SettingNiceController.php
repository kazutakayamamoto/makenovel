<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SettingNice;
class SettingNiceController extends Controller
{
    public function store($booksId,$id)
    {
        SettingNice::create([
            'setting_id'=>$id,
            'user_id'=>\Auth::id(),
        ]);
        //return redirect('/');
        return back();
    }
    public function destroy($booksId,$id)
    {
        $nice=SettingNice::where('setting_id',$id)->where('user_id',\Auth::id())->first();
        $nice->delete();
        //return redirect('/');
        return back();
    }
}
