@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <a href="/">ホームへ戻る</a>
    {!! Form::open(['route' => ['reply.store', $chat_id]]) !!}
        <textarea onpaste="alert('ペースト禁止です'); return false;" name="content" id="chat_content_input" cols="50" rows="5"  wrap="off" onkeyup="document.getElementById('zzzz').value=this.value.length"></textarea>
        <p><input type="text" id="zzzz">/300</p>
        
        <script>
        function lineCheck(e) {
            var ta = document.getElementById("chat_content_input");
            var row = ta.getAttribute("rows");
            var r = (ta.value.split("\n")).length;
            if (document.all) {
                if (r >= row && window.event.keyCode === 13) { //keyCode for IE
                    return false; //入力キーを無視
                }
            } else {
                if (r >= row && e.which === 13) { //which for NN
                    return false;
                }
            }
        }
        window.document.onkeypress = lineCheck;
        </script>
        {!! Form::submit('返信する', ['class' => "btn btn-primary btn-block"]) !!}
    {!! Form::close() !!}
@endsection
