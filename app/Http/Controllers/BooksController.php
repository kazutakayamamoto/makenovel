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
            'title' => 'required|max:30',
            'subject'=>'required|max:600',
            'section_nice_number' => 'required|integer',
            'setting_nice_number'=>'required|integer',
        ]);
        $book = new Book;
        $book->user_id=\Auth::id();
        $book->title=$request->title;
        $book->subject=$request->subject;
        $book->section_nice_number=$request->section_nice_number;
        $book->setting_nice_number=$request->setting_nice_number;
        $book->save();
        return back();
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
            'title' => 'required',
            'subject'=>'required',
        ]);
        $books=Book::where('id',$id)->first();
        $books->title=$request->title;
        $books->subject=$request->subject;
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
