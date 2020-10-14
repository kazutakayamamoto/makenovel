<?php

namespace App\Http\Controllers;
use App\Chat;
use Illuminate\Http\Request;

class ChatReplyController extends Controller
{
    public function create($id)
    {
        return view('chats.reply', [
            'chat_id' => $id,    
        ]);
    }
            
    
    public function store(Request $request,$id)
    {
        $new_section = new Chat;
        $new_section->user_id = \Auth::id(); 
        $new_section->books_id = 1; 
        $new_section->content = $request->content;
        $new_section->save();
        $new_section->reply($id);
        return redirect('/');        
    }
    
}
