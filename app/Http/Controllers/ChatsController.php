<?php

namespace App\Http\Controllers;
use App\Chat;
use App\Book;
use App\ChatReply;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$booksId)
    {
        $page_quantity=5;
        $chats = Chat::where('books_id',$booksId)->orderBy('created_at', 'desc')->paginate($page_quantity);
        if($request->page==NULL){
            $chats_all=Chat::where('books_id',$booksId)->count()-1;
        }else{
            $chats_all=Chat::where('books_id',$booksId)->count()-(($request->page)-1)*$page_quantity-1;
        }
        $books=Book::where('id',$booksId)->first();
        
        foreach($chats as $key=>$chat){
            $chat->chat_replies=ChatReply::where('chat_id',$chat->id)->get();
            $chat->reply_amount=count($chat->chat_replies);
            $chat->number=$chats_all-$key;
        }
        return view('chats.index', [
            'chats' => $chats,
            'books'=>$books,
        ]);                
    }
    
    public function getData($booksId)
    {
        $chats_all=Chat::where('books_id',$booksId)->count()-1;
        $chats = Chat::where('books_id',$booksId)->orderBy('created_at', 'desc')->take(10)->get();
        foreach($chats as $key=>$chat){
            $chat->number=$chats_all-$key;
            $name=$chat->user->name;
            $chat->name=$name;
            $chat->content = nl2br(htmlspecialchars($chat->content));
        }
        $json = ["chats" => $chats];
        return response()->json($json);
    }
    
    public function getReply($id)
    {
        
        $chat = Chat::where('id',$id)->first();
        $chats=Chat::where('books_id',$chat->books_id)->orderBy('created_at', 'desc')->get();
        $chat->number=count($chats->where('id','<',"$chat->id"));
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
    public function store(Request $request,$booksId)
    {
        $request->validate([
            'content' => 'required|max:300',
        ]);
        $new_section = new Chat;
        $new_section->user_id = \Auth::id(); 
        $new_section->books_id = $booksId; 
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
            'books'=>$books,
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
