<?php

namespace App\Http\Controllers;
use App\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $books=Book::first();
        if(is_null($books)){
            $new_book = new Book;
            $new_book->user_id = 1; 
            $new_book->title = 'メインプロジェクト';
            $new_book->subject = 'メインプロジェクト';
            $new_book->section_nice_number=1;
            $new_book->setting_nice_number=1;
            $new_book->save();            
        }
        $books=Book::first();
        //管理ユーザーチェック
        if(\Auth::check()){
            if(\Auth::id()==1){
                
                return view('books.index', [
                    'books'=>$books,
                ]);                
            }else{
                return redirect('/');
            }
        }
    }

    public function create()
    {

    }

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

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'section_nice_number' => 'required',
            'setting_nice_number'=>'required',
        ]);
        $books=Book::first();
        $books->section_nice_number=$request->section_nice_number;
        $books->setting_nice_number=$request->setting_nice_number;
        $books->update();
        return redirect('/');
    }
    public function destroy($id)
    {
        //
    }    
}
