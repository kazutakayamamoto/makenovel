<?php

namespace App\Http\Controllers;
use App\Book;
use App\User;
use App\Section;
use App\SectionTree;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $books=Book::first();
        if(is_null($books)){
            $new_book = new Book;
            $new_book->user_id = 1; 
            $new_book->title = 'メインプロジェクト';
            $new_book->subject = 'メインプロジェクト';
            $new_book->section_nice_number=1;
            $new_book->setting_nice_number=1;
            $new_book->save();            
        }
        $books=Book::first();
        //管理ユーザーチェック
        if(\Auth::check()){
            if(\Auth::id()==1){
                
                return view('books.index', [
                    'books'=>$books,
                ]);                
            }else{
                return redirect('/');
            }
        }
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'title' => 'required|max:30',
            'subject'=>'required|max:600',
            'section_nice_number' => 'required|integer',
            'setting_nice_number'=>'required|integer',
        ]);
        $book = new Book;
        $book->user_id=\Auth::id();
        $book->title=$request->title;
        $book->subject=$request->subject;
        $book->section_nice_number=$request->section_nice_number;
        $book->setting_nice_number=$request->setting_nice_number;
        $book->save();
        
        $booksId=$book->id;
        $books=Book::where('id',$booksId)->first();

        $user=User::first();

        // メッセージ一覧を取得
        $sections = Section::where('books_id',$booksId)->withCount('nices')->orderBy('nices_count','desc')->get();
        $max_section_number=Section::where('books_id',$booksId)->max('section_number');
        if(!empty($sections->where('section_number',$max_section_number)->first())){
            $a= Nice::where('section_id',$sections->where('section_number',$max_section_number)->first()->id)->count();
        }else{
            $a=0;
        }
        if($max_section_number==NULL&&!is_null($user)){
            $new_section = new Section;
            $new_section->user_id = 1; 
            $new_section->books_id = $booksId; 
            $new_section->content = '節題にあったセクションを投稿してください';
            $new_section->section_number=1;
            $new_section->save();
            $sections = Section::where('books_id',$booksId)->withCount('nices')->orderBy('nices_count','desc')->get();
            $max_section_number=Section::where('books_id',$booksId)->max('section_number');
            // return back();
        }
        if($a>$books->section_nice_number&&!is_null($user)){
            $new_section = new Section;
            $new_section->user_id = 1; 
            $new_section->books_id = $booksId; 
            $new_section->content = "いいねが一定値を超えたので新しいセクションが作られました。";
            $new_section->section_number=$max_section_number+1;
            $new_section->save();
            $sections = Section::where('books_id',$booksId)->withCount('nices')->orderBy('nices_count','desc')->get();
            $max_section_number=Section::where('books_id',$booksId)->max('section_number');
            // return back();
        }        


        
        if($request->sort=='new'){
            $new_sections=Section::where('books_id',$booksId)->where('section_number',$max_section_number)->orderBy('created_at','desc')->get();
        }else{
            $new_sections=Section::where('books_id',$booksId)->where('section_number',$max_section_number)->withCount('nices')->orderBy('nices_count','desc')->get();
        }
        $section_tree=SectionTree::where('books_id',$booksId)->where('section_number',$max_section_number)->withCount('nices')->orderBy('nices_count','desc')->first();

        
        // メッセージ一覧ビューでそれを表示
        return view('sections.index', [
            'sections' => $sections,
            'max_section_number'=>$max_section_number,
            'new_sections'=>$new_sections,
            'section_tree'=>$section_tree,
            'books'=>$books,
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'section_nice_number' => 'required',
            'setting_nice_number'=>'required',
            'title' => 'required',
            'subject'=>'required',
        ]);
        $books=Book::where('id',$id)->first();
        $books->title=$request->title;
        $books->subject=$request->subject;
        $books->section_nice_number=$request->section_nice_number;
        $books->setting_nice_number=$request->setting_nice_number;
        $books->update();
        return redirect('/');
    }
    public function destroy($id)
    {
        //
    }    
}
