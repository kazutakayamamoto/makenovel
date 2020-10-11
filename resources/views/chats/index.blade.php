@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <a href="/">ホームへ戻る</a>
    {{ $chats->links() }}
    @if (count($chats) > 0)
        @foreach ($chats as $chat)
        <div id="comment-data">
            <div class="media comment-visible">
                <div class="media-body comment-body chat_child">
                    <span class="chat_id">{!! $chat->id !!}</span>
                    <span class="chat_user">{!! $chat->user->name !!}</span><br>
                    <span id="content">{!! $chat->content !!}</span>
                </div>
            </div>
        </div>
        @endforeach
    @endif
@endsection
