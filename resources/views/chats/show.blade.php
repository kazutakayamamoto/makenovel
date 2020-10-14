@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <a href="/">ホームへ戻る</a>
    @if (count($chats) > 0)
        @foreach ($chats as $chat)
        <div id="comment-data">
            <div class="media comment-visible">
                <div class="media-body comment-body chat_child">
                    <span class="chat_id">{!! $chat->id !!}</span>
                    <span class="chat_user">{!! $chat->user->name !!}</span><br>
                    <span id="content"> 
                    @if(!is_null($chat->reply_number))
                    >> {!! $chat->reply_number !!}<br>
                    @endif
                    {!! $chat->content !!}<br>
                    @if(!empty($chat->replier_number))
                    {!! Form::open(['route' => ['chat.show', $chat->id]]) !!}
                        <button class="btn" type="button submit">{!! $chat->replier_number !!}件の返信</button>
                    {!! Form::close() !!}
                    @endif
                    </span>
                    
                    {!! Form::open(['route' => ['reply.create', $chat->id]]) !!}
                        <button class="nice unnice" type="button submit">返信する</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @endforeach
    @endif
@endsection
