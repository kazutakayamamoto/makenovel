@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script type="module" src="/js/chat.js"></script>

    {!! link_to_route('chats.index', 'チャットに戻る',[$books->id]) !!}
        <div id="comment-data">
            <div class="media comment-visible">
                <div class="media-body comment-body chat_child">
                    <span class="chat_id">{!! $chat_mother->id !!}</span>
                    <span class="chat_user">{!! nl2br(e($chat_mother->user->name)) !!}</span><span class="chat_time">{!! $chat_mother->created_at !!}</span><br>
                    
                    @if(!is_null($chat_mother->reply_number))
                    
                    
                    <button class="btn show_reply" value="{{ $chat_mother->id }}" id="{{ $chat_mother->reply_number }}" > >> {!! $chat_mother->reply_number !!}</button><br>
                    <div class="reply"><div class="reply{{ $chat_mother->id }}"></div></div>
                    
                    @endif
                    <span id="content">{!! $chat_mother->content !!}<br></span>
                    @if(!empty($chat_mother->replier_number))
                    {!! Form::open(['route' => ['chat.show', $books->id,$chat_mother->id]]) !!}
                        <button class="btn btn-reply" type="button submit">{!! $chat_mother->replier_number !!}件の返信</button>
                    {!! Form::close() !!}
                    @endif
                    
                    
                    {!! Form::open(['route' => ['reply.create',$books->id,$chat_mother->id]]) !!}
                        <button class="nice unnice" type="button submit">返信する</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <p color="red" style="font-size:20px;">↑への返信</p>
        <br><br><br><br>
    @if (count($chats) > 0)
        @foreach ($chats as $chat)
        <div id="comment-data">
            <div class="media comment-visible">
                <div class="media-body comment-body chat_child">
                    <span class="chat_id">{!! $chat->id !!}</span>
                    <span class="chat_user">{!! $chat->user->name !!}</span><span class="chat_time">{!! $chat->created_at !!}</span><br>
                     
                    @if(!is_null($chat->reply_number))
                    
                    
                    <button class="btn show_reply" value="{{ $chat->id }}" id="{{ $chat->reply_number }}" > >> {!! $chat->reply_number !!}</button><br>
                    <div class="reply"><div class="reply{{ $chat->id }}">
                        
                    </div></div>
                    
                    @endif
                    <span id="content">{!! $chat->content !!}<br></span>
                    @if(!empty($chat->replier_number))
                    {!! Form::open(['route' => ['chat.show', $books->id,$chat->id]]) !!}
                        <button class="btn btn-reply" type="button submit">{!! $chat->replier_number !!}件の返信</button>
                    {!! Form::close() !!}
                    @endif
                    
                    
                    {!! Form::open(['route' => ['reply.create', $books->id,$chat->id]]) !!}
                        <button class="nice unnice" type="button submit">返信する</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @endforeach
    @endif
@endsection
