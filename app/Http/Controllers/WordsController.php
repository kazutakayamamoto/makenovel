<?php

namespace App\Http\Controllers;
use App\Word;
use App\Setting;
use App\SettingNice;
use App\SettingChat;
use App\Book;

use Illuminate\Http\Request;

class WordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bookId)
    {
        $words = Word::where('books_id',$bookId)->get();
        $books=Book::where('id',$bookId)->first();
        // メッセージ一覧ビューでそれを表示
        return view('words.index', [
            'words' => $words,
            'books'=>$books,
        ]);
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
    public function store(Request $request,$bookId)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|max:20',
        ]);
        $book=Book::where('id',$bookId)->first();
        if($book->user_id == \Auth::id()){
            $new_word = new Word;
            $new_word->books_id = $bookId; 
            $new_word->name=$request->name;
            $new_word->save();
            return back();
        }else{
            return redirect('/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$booksId,$id)
    {
        $page_quantity=20;
        $book = Book::where('id',$booksId)->first();
        $word = Word::where('id',$id)->first();
        if($request->page!=NULL){
            $chats_all=SettingChat::where('word_id',$id)->count()-(($request->page)-1)*$page_quantity-1;
        }else{
            $chats_all=SettingChat::where('word_id',$id)->count()-1;  
        } 
        $chats = SettingChat::where('word_id',$id)->orderBy('created_at', 'desc')->paginate($page_quantity);
        
        foreach($chats as $key=>$chat){
            $chat->number=$chats_all-$key;
            $reply_number = $chat->replies->first();
            $replier_number = $chat->repliers->count();
            if(!is_null($reply_number)){
                $chat->reply_number = $reply_number->id;
                $chat->reply_number_show=$chats->where('id','<',"$reply_number->id")->count();
            }
            if(!is_null($replier_number)){
                $chat->replier_number = $replier_number;
            }
        }
        
        $query = Setting::where('word_id',$id)->withCount('nices');
        $settings_adapt = Setting::fromSub($query, 'alias')->where('nices_count','>',$book->setting_nice_number)->orderBy('nices_count','desc')->get();
        $settings_stay = Setting::fromSub($query, 'alias')->where('nices_count','<=',$book->setting_nice_number)->orderBy('nices_count','desc')->get();
        // $settings_adapt = Setting::where('word_id',$id)->withCount('nices')->having('nices_count','>',1)->orderBy('nices_count','desc')->get();
        // $settings_stay = Setting::where('word_id',$id)->withCount('nices')->having('nices_count','<=',1)->orderBy('nices_count','desc')->get();
        
        // メッセージ一覧ビューでそれを表示
        return view('words.show', [
            'word' => $word,
            'settings_adapt'=>$settings_adapt,
            'settings_stay'=>$settings_stay,
            'chats'=>$chats,
            'books'=>$book,
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
    public function update(Request $request,$booksId,$id)
    {
        $word = Word::findOrFail($id);
        $word->name = $request->name;
        $word->save();

        return back();          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($booksId,$id)
    {
        $word = Word::findOrFail($id);
        $word->delete();
        
        // 前のURLへリダイレクトさせる
        return back();
    }
}