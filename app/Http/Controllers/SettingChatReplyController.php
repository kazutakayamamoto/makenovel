<?php

namespace App\Http\Controllers;
use App\Word;
use App\SettingChat;
use App\Book;
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
        $new_section = new SettingChat;
        $new_section->user_id = \Auth::id(); 
        $new_section->word_id = $word_id; 
        $new_section->content = $request->content;
        $new_section->save();
        $new_section->reply($id);
        $word=Word::where('id',$word_id)->first();
        return redirect()->action(
            'WordsController@show',[$booksId,'word' => $word_id]
        );  
    }
}
