@extends('layouts.app')

@section('content')
    
    {!! Form::model($book, ['route' => ['books.update', $book->id], 'method' => 'put']) !!}
        <div class="form-group">

            <p>タイトル</p>
            <textarea name="title" cols="30" rows="1"  wrap="off" onkeyup="document.getElementById('zzzz').value=this.value.length">{{ $book->title }}</textarea>
            <p><input type="text" id="zzzz">/30</p>
            <p>本の内容</p>
            <textarea name="subject" cols="50" rows="5"  wrap="off" onkeyup="document.getElementById('xxxx').value=this.value.length">{{ $book->subject }}</textarea>
            <p><input type="text" id="xxxx">/600</p>
            <p>セクションいいねは{{$book->section_nice_number}}を超えると新しいセクションができます。</p>
            <p><input type="number" name="section_nice_number"></p>
            <p>設定いいねは{{$book->setting_nice_number}}を超えると新しい設定ができます。</p>
            {!! Form::label('setting_nice_number', '設定いいね:') !!}
            <p><input type="number" name="setting_nice_number"></p>
        </div>
        {!! Form::submit('更新', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

@endsection