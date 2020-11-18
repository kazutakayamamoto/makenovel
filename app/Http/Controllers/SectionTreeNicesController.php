<?php

namespace App\Http\Controllers;
use App\SectionTreeNice;
use App\SectionTree;
use Illuminate\Http\Request;

class SectionTreeNicesController extends Controller
{
    public function store($booksId,$id)
    {
        $section_tree=SectionTree::where('id',$id)->first();
        if($section_tree->user_id==1){
            return back();
        }
        SectionTreeNice::create([
            'section_tree_id'=>$id,
            'user_id'=>\Auth::id(),
        ]);
        //return redirect('/');
        return back();
    }
    public function destroy($booksId,$id)
    {
        $section_tree=SectionTree::where('id',$id)->first();
        if($section_tree->user_id==1){
            return back();
        }
        $nice=SectionTreeNice::where('section_tree_id',$id)->where('user_id',\Auth::id())->first();
        $nice->delete();
        //return redirect('/');
        return back();
    }
}
