<?php

namespace App\Http\Controllers;
use App\Word;
use App\Setting;
use Illuminate\Http\Request;

class WordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $words = Word::all();
        // メッセージ一覧ビューでそれを表示
        return view('words.index', [
            'words' => $words,
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
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|max:20',
        ]);
        
        $new_word = new Word;
        $new_word->book_id = 1; 
        $new_word->name=$request->name;
        $new_word->save();
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
        $word = Word::where('id',$id)->first();
        if(is_null(Setting::where('word_id',$id)->first())){
            $new_setting = new Setting;
            $new_setting->word_id = $id; 
            $new_setting->user_id = 1;
            $new_setting->content= '新しい設定を追加してください。';
            $new_setting->save();            
        }
        if(!is_null(Setting::where('word_id',$id)->first()))$settings_adapt = Setting::where('word_id',$id)->withCount('nices')->having('nices_count','>',1)->get();
        if(!is_null(Setting::where('word_id',$id)->first()))$settings_stay = Setting::where('word_id',$id)->withCount('nices')->having('nices_count','<=',1)->orderBy('nices_count','desc')->get();
        
        // メッセージ一覧ビューでそれを表示
        return view('words.show', [
            'word' => $word,
            'settings_adapt'=>$settings_adapt,
            'settings_stay'=>$settings_stay,
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
