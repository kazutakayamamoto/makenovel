<?php

namespace App\Http\Controllers;
use App\Chat;
use App\Book;
use Illuminate\Http\Request;

class ChatReplyController extends Controller
{
    public function create($booksId,$id)
    {
        $books=Book::where('id',$booksId)->first();
        return view('chats.reply', [
            'chat_id' => $id,
            'books'=>$books,
        ]);
    }
            
    
    public function store(Request $request,$booksId,$id)
    {
        $new_section = new Chat;
        $new_section->user_id = \Auth::id(); 
        $new_section->books_id = 1; 
        $new_section->content = $request->content;
        $new_section->save();
        $new_section->reply($id);
        return redirect()->action(
            'ChatsController@index',[$booksId]
        );         
    }
    
}
