<?php

namespace App\Http\Controllers;
use App\SectionTreeNice;
use Illuminate\Http\Request;

class SectionTreeNicesController extends Controller
{
    public function store($id)
    {
        SectionTreeNice::create([
            'section_tree_id'=>$id,
            'user_id'=>\Auth::id(),
        ]);
        //return redirect('/');
        return back();
    }
    public function destroy($id)
    {
        $nice=SectionTreeNice::where('section_tree_id',$id)->where('user_id',\Auth::id())->first();
        $nice->delete();
        //return redirect('/');
        return back();
    }
}
