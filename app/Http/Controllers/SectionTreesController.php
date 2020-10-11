<?php

namespace App\Http\Controllers;
use App\Section;
use App\SectionTree;
use App\User;
use App\Nice;
use App\UnderPlot;
use Illuminate\Http\Request;

class SectionTreesController extends Controller
{
    public function index(Request $request)
    {
        $section_trees = SectionTree::all();
        return view('section_tree.index', [
            'section_trees' => $section_trees,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:300',
        ]);
        
        $max_section_number=SectionTree::max('section_number');
        if($max_section_number==null)$max_section_number=0;
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $new_section = new SectionTree;
        $new_section->user_id = \Auth::id(); 
        $new_section->books_id = 1; 
        $new_section->content = $request->content;
        $new_section->section_number=$max_section_number+1;
        $new_section->save();
        return back();
    }

    public function store2(Request $request,$id)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
        ]);
        $max_section_number=Section::max('section_number');
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $new_section = new SectionTree;
        $new_section->user_id = \Auth::id(); 
        $new_section->books_id = 1; 
        $new_section->content = $request->content;
        $new_section->section_number=$id;
        $new_section->save();
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
        // メッセージ一覧を取得
        $sections = Section::where('section_number',$id)->withCount('nices')->orderBy('nices_count','desc')->get();
        // メッセージ一覧ビューでそれを表示
        return view('sections.show', [
            'sections' => $sections,
        ]);        
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
    public function destroy($id)
    {
        //
    }
}
