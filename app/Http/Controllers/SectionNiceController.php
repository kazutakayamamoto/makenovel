<?php

namespace App\Http\Controllers;
use App\Section;
use Illuminate\Http\Request;
use App\Nice;

class SectionNiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($booksId,$id)
    {
        $section=Section::where('id',$id)->first();
        if($section->user_id==1){
            return back();
        }
        Nice::create([
            'section_id'=>$id,
            'user_id'=>\Auth::id(),
        ]);
        //return redirect('/');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($booksId,$id)
    {
        $section=Section::where('id',$id)->first();
        if($section->user_id==1){
            return back();
        }

        $nice=Nice::where('section_id',$id)->where('user_id',\Auth::id())->first();
        $nice->delete();
        //return redirect('/');
        return back();
    }
    

}
