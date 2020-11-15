<?php

namespace App\Http\Controllers;
use App\Section;
use App\SectionTree;
use App\User;
use App\Nice;
use App\UnderPlot;
use App\Word;
use App\Book;

use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mainpage()
    {
        //ブラックリストに登録したユーザーをログアウト
        if(\Auth::check()){
            $user = \Auth::user();
            if ($user->is_black(\Auth::id())) {
                \Auth::logout();
                return redirect('/');
            }
        }
        //作成されている本を取得
        $books=Book::all();
        // メッセージ一覧ビューでそれを表示
        return view('sections.mainpage', [
            'books' => $books,
        ]);        
    }
    public function index(Request $request,$booksId)
    {
        $books=Book::where('id',$booksId)->first();

        $user=User::first();

        // メッセージ一覧を取得
        $sections = Section::where('books_id',$booksId)->withCount('nices')->orderBy('nices_count','desc')->get();
        $max_section_number=Section::where('books_id',$booksId)->max('section_number');
        
        if(!empty($sections->where('section_number',$max_section_number)->first())){
            $a= Nice::where('section_id',$sections->where('section_number',$max_section_number)->first()->id)->count();
        }else{
            $a=0;
        }
        if($max_section_number==NULL&&!is_null($user)){
            $new_section = new Section;
            $new_section->user_id = 1; 
            $new_section->books_id = $booksId; 
            $new_section->content = '節題にあったセクションを投稿してください';
            $new_section->section_number=1;
            $new_section->save();
            return back();
        }
        if($a>$books->section_nice_number&&!is_null($user)){
            $new_section = new Section;
            $new_section->user_id = 1; 
            $new_section->books_id = $booksId; 
            $new_section->content = "いいねが一定値を超えたので新しいセクションが作られました。";
            $new_section->section_number=$max_section_number+1;
            $new_section->save();
            return back();
        }
        
        if($request->sort=='new'){
            $new_sections=Section::where('books_id',$booksId)->where('section_number',$max_section_number)->orderBy('created_at','desc')->get();
        }else{
            $new_sections=Section::where('books_id',$booksId)->where('section_number',$max_section_number)->withCount('nices')->orderBy('nices_count','desc')->get();
        }
        $section_tree=SectionTree::where('books_id',$booksId)->where('section_number',$max_section_number)->withCount('nices')->orderBy('nices_count','desc')->first();

        
        // メッセージ一覧ビューでそれを表示
        return view('sections.index', [
            'sections' => $sections,
            'max_section_number'=>$max_section_number,
            'new_sections'=>$new_sections,
            'section_tree'=>$section_tree,
            'books'=>$books,
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
    
    public function rule()
    {
        return view('auth.rule', [
        ]);
    }
    public function privacy()
    {
        return view('auth.privacy', [
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$booksId)
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
        $new_section->books_id = $booksId; 
        $new_section->content = $request->content;
        $new_section->section_number=$max_section_number;
        $new_section->under_plot = $request->under_plot;
        $new_section->save();
        return back();
    }

    public function store2(Request $request,$booksId,$id)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:300',
        ]);
        $max_section_number=Section::max('section_number');
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->sections()->create([
            'content' => $request->content,
            'section_number'=>$id,
            'books_id'=>$booksId,
            'under_plot'=>$request->under_plot,
        ]);

        return back();
    }
    public function future_store(Request $request,$booksId)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:300',
        ]);
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->sections()->create([
            'content' => $request->content,
            'section_number'=>0,
            'books_id'=>$booksId,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($booksId,$id)
    {
        // メッセージ一覧を取得
        $sections = Section::where('books_id',$booksId)->where('section_number',$id)->withCount('nices')->orderBy('nices_count','desc')->get();
        $section_tree=SectionTree::where('books_id',$booksId)->where('section_number',$id)->withCount('nices')->orderBy('nices_count','desc')->first();
        $books=Book::where('id',$booksId)->first();
        // メッセージ一覧ビューでそれを表示
        return view('sections.show', [
            'sections' => $sections,
            'section_tree' => $section_tree,
            'books'=>$books,
        ]);
    }
    public function future_show($booksId)
    {
        $sections = Section::where('books_id',$booksId)->where('section_number',0)->withCount('nices')->orderBy('nices_count','desc')->get();
        $books=Book::where('id',$booksId)->first();
        // メッセージ一覧ビューでそれを表示
        return view('sections.future_show', [
            'sections' => $sections,
            'books'=>$books,
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
