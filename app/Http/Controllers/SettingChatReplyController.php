<?php

namespace App\Http\Controllers;
use App\Word;
use App\SettingChat;
use Illuminate\Http\Request;

class SettingChatReplyController extends Controller
{
    public function create($word_id,$id)
    {
        return view('words.reply', [
            'chat_id' => $id,
            'word_id' => $word_id,
        ]);
    }
            
    
    public function store(Request $request,$word_id,$id)
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
            'WordsController@show',['word' => $word_id]
        );  
    }
}
