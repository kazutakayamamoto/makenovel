<?php

namespace App\Http\Controllers;
use App\SettingChat;
use Illuminate\Http\Request;

class SettingChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $chats = SettingChat::where('word_id',$id)->orderBy('created_at', 'desc')->paginate(15);
        foreach($chats as $chat){
            $reply_number = $chat->replies->first();
            $replier_number = $chat->repliers->count();
            if(!is_null($reply_number)){
                $chat->reply_number = $reply_number->id;
            }
            if(!is_null($replier_number)){
                $chat->replier_number = $replier_number;
            }
        }
        return view('words.words_show', [
            'chats' => $chats,
        ]);                
    }
    public function getData($id)
    {
        $chats = SettingChat::where('word_id',$id)->orderBy('created_at', 'desc')->take(10)->get();
        foreach($chats as $chat){
            $name=$chat->user->name;
            $chat->name=$name;
            $chat->content = nl2br(htmlspecialchars($chat->content));
            
            $reply_number = $chat->replies->first();
            $replier_number = $chat->repliers->count();
            if(!is_null($reply_number)){
                $chat->reply_number = $reply_number->id;
            }
            if(!is_null($replier_number)){
                $chat->replier_number = $replier_number;
            }
        }
        $json = ["chats" => $chats];
        return response()->json($json);
    }
    
    public function getReply($id)
    {
        $chat = SettingChat::where('id',$id)->first();
        $chat->content = nl2br(htmlspecialchars($chat->content));
        $name=$chat->user->name;
        $chat->name=$name;
        $reply_number = $chat->replies->first();
        $replier_number = $chat->repliers->count();
        if(!is_null($reply_number)){
            $chat->reply_number = $reply_number->id;
        }
        if(!is_null($replier_number)){
            $chat->replier_number = $replier_number;
        }
        $json = ["chat" => $chat];
        return response()->json($json);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $new_section = new SettingChat;
        $new_section->user_id = \Auth::id(); 
        $new_section->word_id = $id; 
        $new_section->content = $request->content;
        $new_section->save();
        return back();        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chat_mother = SettingChat::where('id',$id)->first();
        $chats = $chat_mother->repliers;
        
        $reply_number = $chat_mother->replies->first();
        $replier_number = $chat_mother->repliers->count();
        if(!is_null($reply_number)){
            $chat_mother->reply_number = $reply_number->id;
        }
        if(!is_null($replier_number)){
            $chat_mother->replier_number = $replier_number;
        }
        foreach($chats as $chat){
            $reply_number = $chat->replies->first();
            $replier_number = $chat->repliers->count();
            if(!is_null($reply_number)){
                $chat->reply_number = $reply_number->id;
            }
            if(!is_null($replier_number)){
                $chat->replier_number = $replier_number;
            }
        }
        return view('words.wordshow', [
            'chats' => $chats,
            'chat_mother' => $chat_mother,
        ]);                        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
