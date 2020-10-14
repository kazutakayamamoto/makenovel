<?php

namespace App\Http\Controllers;
use App\Chat;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = Chat::orderBy('created_at', 'desc')->paginate(15);
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
        return view('chats.index', [
            'chats' => $chats,
        ]);                
    }
    
    public function getData()
    {
        $chats = Chat::orderBy('created_at', 'desc')->take(10)->get();
        foreach($chats as $chat){
            $name=$chat->user->name;
            $chat->name=$name;
        }
        $json = ["chats" => $chats];
        return response()->json($json);
    }
    
    public function getReply($id)
    {
        $chat = Chat::where('id',$id)->first();
        $name=$chat->user->name;
        $chat->name=$name;
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
    public function store(Request $request)
    {
        $new_section = new Chat;
        $new_section->user_id = \Auth::id(); 
        $new_section->books_id = 1; 
        $new_section->content = $request->content;
        $new_section->save();
        return redirect('/');        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chat_mother = Chat::where('id',$id)->first();
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
        return view('chats.show', [
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
