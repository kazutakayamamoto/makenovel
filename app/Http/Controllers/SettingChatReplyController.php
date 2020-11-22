<?php

namespace App\Http\Controllers;
use App\Word;
use App\SettingChat;
use App\Book;
use App\SettingChatReply;
use Illuminate\Http\Request;

class SettingChatReplyController extends Controller
{
    public function create($booksId,$word_id,$id)
    {
        $books=Book::where('id',$booksId)->first();
        return view('words.reply', [
            'chat_id' => $id,
            'word_id' => $word_id,
            'books'=>$books,
        ]);
    }
            
    
    public function store(Request $request,$booksId,$word_id,$id)
    {
        $request->validate([
            'content' => 'required|max:300',
        ]);
        $new_chat = new SettingChatReply;
        $new_chat->user_id = \Auth::id(); 
        $new_chat->setting_chat_id = $id; 
        $new_chat->content = $request->content;
        $new_chat->save();
        return redirect()->action(
            'WordsController@show',[$booksId,'word' => $word_id]
        );  
    }
}
