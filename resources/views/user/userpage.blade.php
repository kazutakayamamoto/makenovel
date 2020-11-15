@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
<!--本の追加編集-->
    <div class="row">
        作成した本の一覧
        <div class="book_container col-12">
            @if(count($books)>0)
                @foreach ($books as $book)
                    <div class="book_show">
                        <p>{!! link_to_route('section.main', nl2br(e($book->title)),[$book->id]) !!}</p>
                        {!! link_to_route('book.edit', '本の設定を変更する',[$book->id],['class' => 'btn btn-primary']) !!}
                    </div>
                @endforeach
            @endif
        </div>
        <!--本の追加-->
        {!! Form::open(['route' => 'books.store']) !!}
        <div class="form-group register_book col-12">
            <p>タイトル</p>
            <textarea name="title" cols="30" rows="1"  wrap="off" onkeyup="document.getElementById('zzzz').value=this.value.length"></textarea>
            <p><input type="text" id="zzzz">/30</p>
            <p>本の内容</p>
            <textarea name="subject" cols="50" rows="5"  wrap="off" onkeyup="document.getElementById('xxxx').value=this.value.length"></textarea>
            <p><input type="text" id="xxxx">/600</p>
            {!! Form::label('section_nice_number', 'セクションいいね:') !!}
            <p><input type="number" name="section_nice_number"></p>

            {!! Form::label('setting_nice_number', '設定いいね:') !!}
            <p><input type="number" name="setting_nice_number"></p>
            <div class="col-lg-5">
            {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
            </div>
        </div>
    {!! Form::close() !!}
    </div>
@endsection