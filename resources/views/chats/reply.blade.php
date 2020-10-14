@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <a href="/">ホームへ戻る</a>
    {!! Form::open(['route' => ['reply.store', $chat_id]]) !!}
        @if (Auth::id())
            <div class="col-md-8">
                <div class="form-group">
                    <textarea name="content" cols="30" rows="2" onkeyup="document.getElementById('zzzz').value=this.value.length"></textarea>
                    <input type="text" id="zzzz">/300
                </div>
            </div>
        @endif
        {!! Form::submit('返信する', ['class' => "btn btn-primary btn-block"]) !!}
    {!! Form::close() !!}
@endsection
