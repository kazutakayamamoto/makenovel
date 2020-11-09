@extends('layouts.app')

@section('content')
<!--本の追加編集-->
    
    {!! Form::open(['route' => 'books.store']) !!}
        <div class="form-group">
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
        </div>
        <div class="col-lg-5">
        {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
        </div>
    {!! Form::close() !!}

@endsection