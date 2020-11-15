<?php

namespace App\Http\Controllers;
use App\Book;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        //ユーザーの作成した本を取得
        $id=\Auth::id();

        $books=Book::where('user_id',$id)->get();
        return view('user.userpage', [
            'books'=>$books,    
        ]);                
    }
    public function edit($booksId)
    {
        //ユーザーの作成した本を取得
        $id=\Auth::id();
        
        $book=Book::where('user_id',$id)->where('id',$booksId)->first();
        //ユーザーの作成した本かチェック
        if(!is_null($book)>0){
            return view('books.index', [
                'book'=>$book,    
            ]);
        }else{
            return redirect('/');
        }
    }    
}
