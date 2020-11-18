<?php

namespace App\Http\Controllers;
use App\ChatReply;
use Illuminate\Http\Request;

class ChatReplyController extends Controller
{
    public function store(Request $request,$booksId,$chatId)
    {
        $request->validate([
            'content' => 'required|max:300',
        ]);
        $new_chat = new ChatReply;
        $new_chat->user_id = \Auth::id(); 
        $new_chat->chat_id = $chatId; 
        $new_chat->content = $request->content;
        $new_chat->save();
        return back();        
    }
}
