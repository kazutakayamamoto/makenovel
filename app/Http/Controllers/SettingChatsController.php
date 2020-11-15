<?php

namespace App\Http\Controllers;
use App\SettingChat;
use App\Book;
use App\Word;
use Illuminate\Http\Request;

class SettingChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$booksId,$id)
    {
        $page_quantity=15;
        $chats = SettingChat::where('word_id',$id)->orderBy('created_at', 'desc')->paginate($page_quantity);
        $chats_all=SettingChat::where('word_id',$id)->count()-(($request->page)-1)*$page_quantity-1;
        $books=Book::where('id',$booksId)->first();
        foreach($chats as $key=>$chat){
            $chat->number=$chats_all-$key;
            $reply_number = $chat->replies->first();
            $replier_number = $chat->repliers->count();
            if(!is_null($reply_number)){
                $chat->reply_number = $reply_number->id;
                $chat->reply_number_show=SettingChat::where('word_id',$id)->orderBy('created_at', 'desc')->where('id','<',"$reply_number->id")->count();
            }
            if(!is_null($replier_number)){
                $chat->replier_number = $replier_number;
            }
        }
        return view('words.words_show', [
            'chats' => $chats,
            'books'=>$books,
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
        $chats=SettingChat::where('word_id',$chat->word_id)->orderBy('created_at', 'desc')->get();
        $chat->number=$chats->where('id','<',"$id")->count();
        $chat->content = nl2br(htmlspecialchars($chat->content));
        $name=$chat->user->name;
        $chat->name=$name;
        $reply_number = $chat->replies->first();
        $replier_number = $chat->repliers->count();
        if(!is_null($reply_number)){
            $chat->reply_number = $reply_number->id;
            $chat->reply_number_show=$chats->where('id','<',"$reply_number->id")->count();
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
    public function store(Request $request,$booksId,$id)
    {
        $request->validate([
            'content' => 'required|max:300',
        ]);

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
    public function show($booksId,$id)
    {

        $books=Book::where('id',$booksId)->first();
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
        $word=Word::where('id',$chats->first()->word_id)->first();
        return view('words.wordshow', [
            'chats' => $chats,
            'chat_mother' => $chat_mother,
            'books'=>$books,
            'word'=>$word,
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
