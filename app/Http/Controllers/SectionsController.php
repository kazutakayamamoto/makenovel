<?php

namespace App\Http\Controllers;
use App\Section;
use App\SectionTree;
use App\User;
use App\Nice;
use App\UnderPlot;
use App\Word;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {

        // メッセージ一覧を取得
        $sections = Section::withCount('nices')->orderBy('nices_count','desc')->get();
        $max_section_number=Section::max('section_number');
        
        if(!empty($sections->where('section_number',$max_section_number)->first())){
            $a= Nice::where('section_id',$sections->where('section_number',$max_section_number)->first()->id)->count();
        }else{
            $a=0;
        }
        if($a>1){
            $user = User::first();
            $user->sections()->create([
                'books_id'=>1,
                'content' => 'いいねが2を超えたので新しいセクションが作られました。',
                'section_number'=>$max_section_number+1,
            ]);
            return redirect('/');
        }
        if($request->sort=='new'){
            $new_sections=Section::where('section_number',$max_section_number)->orderBy('created_at','desc')->get();
        }else{
            $new_sections=Section::where('section_number',$max_section_number)->withCount('nices')->orderBy('nices_count','desc')->get();
        }
        $section_tree=SectionTree::where('section_number',$max_section_number)->withCount('nices')->orderBy('nices_count','desc')->first();
        //管理ユーザーチェック
        if(\Auth::check()){
            if(\Auth::id()==1){
                $words = Word::all();
                $users = User::all();
                return view('admin.word', [
                    'users'=>$users,
                    'words'=>$words,
                ]);                
            }
        }
        // メッセージ一覧ビューでそれを表示
        return view('sections.index', [
            'sections' => $sections,
            'max_section_number'=>$max_section_number,
            'new_sections'=>$new_sections,
            'section_tree'=>$section_tree,
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
            'under_plot'=>'max:300',
        ]);
        
        $max_section_number=Section::max('section_number');
        if($max_section_number==null)$max_section_number=1;
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $new_section = new Section;
        $new_section->user_id = \Auth::id(); 
        $new_section->books_id = 1; 
        $new_section->content = $request->content;
        $new_section->section_number=$max_section_number;
        $new_section->under_plot = $request->under_plot;
        $new_section->save();
        return redirect('/');
    }

    public function store2(Request $request,$id)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
        ]);
        $max_section_number=Section::max('section_number');
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->sections()->create([
            'content' => $request->content,
            'section_number'=>$id,
            'books_id'=>1,
            'under_plot'=>$request->under_plot,
        ]);

        return back();
    }
    public function future_store(Request $request,$id)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
        ]);
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->sections()->create([
            'content' => $request->content,
            'section_number'=>0,
            'books_id'=>1,
        ]);

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
        $section_tree=SectionTree::where('section_number',$id)->withCount('nices')->orderBy('nices_count','desc')->first();;
        // メッセージ一覧ビューでそれを表示
        return view('sections.show', [
            'sections' => $sections,
            'section_tree' => $section_tree,
        ]);        
    }
    public function future_show()
    {

  $query = Section::where('section_number',0)->withCount('nices');
  $sections = Section::fromSub($query, 'alias')->orderBy('nices_count','desc')->get();
        // メッセージ一覧ビューでそれを表示
        return view('sections.future_show', [
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
