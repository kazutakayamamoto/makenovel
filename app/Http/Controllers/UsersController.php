<?php

namespace App\Http\Controllers;
use App\Book;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $id=\Auth::id();
        if($id!=1){
            return view('user.construction', [
            ]);             
        }
        $books=Book::where('user_id',$id)->get();
        return view('user.userpage', [
            'books'=>$books,    
        ]);                
    }
}
