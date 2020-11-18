@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script type="module" src="/js/chat.js"></script>
    <p>{!! link_to_route('section.main', nl2br(e($books->title)),[$books->id]) !!}のメインページへ戻る</p>
    {{ $chats->links() }}
    @if (count($chats) > 0)
        @foreach ($chats as $chat)
        <div id="comment-data">
            <div class="media comment-visible">
                <div class="media-body comment-body chat_child">
                    <span class="chat_id">{!! $chat->number !!}</span>
                    <span class="chat_user">{!! $chat->user->name !!}</span><span class="chat_time">{!! $chat->created_at !!}</span><br>
                    <span id="content">{!! nl2br(e($chat->content)) !!}</span><br>
                    
                    <!--ここから返信を表示-->
                    
                        <p class="show_button" id="{{ $chat->id }}">{{$chat->reply_amount}}件の返信</p>
                        <div class="Replies {{ $chat->id }}_show">
                            @foreach ($chat->chat_replies as $reply)
                                <div class="Reply">
                                <span class="chat_user">{!! $reply->user->name !!}</span><span class="chat_time">{!! $reply->created_at !!}</span><br>
                                <span id="content">{!! nl2br(e($reply->content)) !!}</span><br>
                                </div>
                            @endforeach
                            <div class="store_reply">
                            {!! Form::open(['route' => ['reply.store', $books->id,$chat->id]]) !!}
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
                                {!! Form::submit('返信する', ['class' => "btn unnice"]) !!}
                            {!! Form::close() !!}
                            </div>
                        </div>
                    
                    <!--返信ここまで-->
                </div>
            </div>
        </div>
        @endforeach
    @endif
@endsection
