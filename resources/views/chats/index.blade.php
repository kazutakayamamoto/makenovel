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
                    
                    @if(!is_null($chat->reply_number))
                    
                    
                    <button class="btn show_reply" value="{{ $chat->id }}" id="{{ $chat->reply_number }}" > >> {!! $chat->reply_number_show !!}</button><br>
                    <div class="reply{{ $chat->id }}"></div>
                    
                    @endif
                    <span id="content">{!! nl2br(e($chat->content)) !!}</span><br>
                    @if(!empty($chat->replier_number))
                    {!! Form::open(['route' => ['chat.show',$books->id,$chat->id]]) !!}
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
