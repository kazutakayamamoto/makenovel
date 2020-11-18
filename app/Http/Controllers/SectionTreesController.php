<?php

namespace App\Http\Controllers;
use App\Section;
use App\SectionTree;
use App\SectionTreeNice;
use App\User;
use App\Nice;
use App\UnderPlot;
use App\Book;
use Illuminate\Http\Request;

class SectionTreesController extends Controller
{
    public function index(Request $request,$booksId)
    {
        $books=Book::where('id',$booksId)->first();
        $section_trees = SectionTree::where('books_id',$booksId)->withCount('nices')->orderBy('nices_count','desc')->get();
        $max_section_number = SectionTree::where('books_id',$booksId)->max('section_number');
        if(!empty($section_trees->where('section_number',$max_section_number)->first())){
            $a= SectionTreeNice::where('section_tree_id',$section_trees->where('section_number',$max_section_number)->first()->id)->count();
        }else{
            $a=0;
        }
        if($a>=$books->section_nice_number){
            $user = User::first();
            $user->section_trees()->create([
                'books_id'=>$booksId,
                'content' => "いいねが一定値を超えたので新しいセクションツリーが作られました。 投稿してください。",
                'section_number'=>$max_section_number+1,
            ]);
            $section_trees = SectionTree::where('books_id',$booksId)->withCount('nices')->orderBy('nices_count','desc')->get();
            $max_section_number = SectionTree::where('books_id',$booksId)->max('section_number');
            
        }
        if($max_section_number==NULL){
            $user = User::first();
            $new_section_tree=new SectionTree;
            $new_section_tree->user_id=1;
            $new_section_tree->books_id=$booksId;
            $new_section_tree->section_number=1;
            $new_section_tree->content='いいねが一定値を超えたので新しいセクションツリーが作られました。 投稿してください。';
            $new_section_tree->save();
        
            $section_trees = SectionTree::where('books_id',$booksId)->withCount('nices')->orderBy('nices_count','desc')->get();
            $max_section_number = SectionTree::where('books_id',$booksId)->max('section_number');
        }
        $number = Section::max('section_number');
        return view('section_tree.index', [
            'section_trees' => $section_trees,
            'max_section_number'=>$max_section_number,
            'number' => $number,
            'books' => $books,
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
    public function store(Request $request,$booksId)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:50',
        ]);
        
        $max_section_number=SectionTree::where('books_id',$booksId)->max('section_number');
        if($max_section_number==null)$max_section_number=0;
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $new_section = new SectionTree;
        $new_section->user_id = \Auth::id(); 
        $new_section->books_id = $booksId; 
        $new_section->content = $request->content;
        $new_section->section_number=$max_section_number;
        $new_section->save();
        return back();
    }

    public function store2(Request $request,$booksId,$id)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:50',
        ]);
        $max_section_number=Section::where('books_id',$booksId)->max('section_number');
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $new_section = new SectionTree;
        $new_section->user_id = \Auth::id(); 
        $new_section->books_id = $booksId; 
        $new_section->content = $request->content;
        $new_section->section_number = $id;
        $new_section->save();
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
        $books=Book::where('id',$booksId)->first();
        // メッセージ一覧を取得
        $section_trees = SectionTree::where('books_id',$booksId)->where('section_number',$id)->withCount('nices')->orderBy('nices_count','desc')->get();
        // メッセージ一覧ビューでそれを表示
        return view('section_tree.show', [
            'section_trees' => $section_trees,
            'section_number'=> $id,
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
