@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<!--<script type="module" src="/js/words_show.js"></script>-->
<script type="module" src="/js/index.1.js"></script>

    {!! link_to_route('words.index', '設定一覧に戻る',[$books->id],['class' => 'btn btn-primary']) !!}
    <p>{!! '名前:' !!}{!! $word->name !!}</p>
    <div class="row">
        
        <div class="box2 col-lg-6">
            いいねが{!! $books->setting_nice_number !!}を超えたもの
            @if (count($settings_adapt) > 0)
                @foreach ($settings_adapt as $setting)
                    <div class="box3">
                        名前:{!! nl2br(e($setting->user->name)) !!}
                        {!! 'いいねの数:' !!}{{$setting->nices_count}}
                        <p class="mb-0">{!! nl2br(e($setting->content)) !!}</p>
                        
                        @if ($setting->is_nice($setting->id,Auth::id()))
                            {!! Form::open(['route' => ['setting.unnice',$books->id,$setting->id],'method' => 'delete']) !!}
                                <button class="nice unnice" type="button submit">いいねを外す</button>
                            {!! Form::close() !!}
                        @else
                            {!! Form::open(['route' => ['setting.nice', $books->id,$setting->id]]) !!}
                                <button class="nice" type="button submit">いいね</button>
                            {!! Form::close() !!}
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        <div class="box2 col-lg-6">
            
            <div class="show_plus_section"><i class="far fa-2x fa-plus-square"></i>&nbsp;&nbsp;追加する</div>
            {!! Form::open(['route' => ['settings.store',$books->id,$word->id]]) !!}
                <div class="form-group setting-form">
                    <textarea name="content" cols="50" rows="5" wrap="hard" placeholder="100文字以内で追加したい設定を書き込んでください。" onkeyup="document.getElementById('yyyy').value=this.value.length"></textarea>
                    <input type="text" id="yyyy">/100
                    <p></p>
                    {!! Form::submit('設定を投稿する', ['class' => 'btn btn-primary btn-block']) !!}
                    {!! Form::close() !!}
                </div>
            @if (count($settings_stay) > 0)
                @foreach ($settings_stay as $setting)
                <div class="box3">
                    名前:{!! nl2br(e($setting->user->name)) !!}
                    {!! 'いいねの数:' !!}{{$setting->nices_count}}
                    <p class="mb-0">{!! nl2br(e($setting->content)) !!}</p>
                    @if ($setting->is_nice($setting->id,Auth::id()))
                        {!! Form::open(['route' => ['setting.unnice',$books->id,$setting->id],'method' => 'delete']) !!}
                            <button class="nice unnice" type="button submit">いいねを外す</button>
                        {!! Form::close() !!}
                    @else
                        {!! Form::open(['route' => ['setting.nice',$books->id,$setting->id]]) !!}
                            <button class="nice" type="button submit">いいね</button>
                        {!! Form::close() !!}
                    @endif
                </div>
                @endforeach
            @endif
            
        </div>
    </div>
    
    
    
        <!--チャットここから-->
        <div class="row">
                <div class="col-lg-12 chat-comment">
                <!--<i class="fas fa-arrow-alt-circle-up"></i>{!! link_to_route('chats.index', '過去のチャットを見る',[$books->id], ['class' => 'btn btn-primary']) !!}-->
                
                <p>{!! $word->name !!}について語るスレ</p>
                <script type="module" src="/js/chat.2.js"></script>
                    {{ $chats->links() }}
                    @if (count($chats) > 0)
                        @foreach ($chats as $chat)
                        <div id="comment-data">
                            <div class="media comment-visible">
                                <div class="media-body comment-body chat_child">
                                    <span class="chat_id">{!! $chat->id !!}</span>
                                    <span class="chat_user">{!! $chat->user->name !!}</span><span class="chat_time">{!! $chat->created_at !!}</span>
                                    <br>
                                    
                                    @if(!is_null($chat->reply_number))
                                    
                                    
                                    <button class="btn show_reply" value="{{ $chat->id }}" id="{{ $chat->reply_number }}" > >> {!! $chat->reply_number !!}</button><br>
                                    <div class="reply{{ $chat->id }}"></div>
                                    
                                    @endif
                                    <span id="content">{!! nl2br(e($chat->content)) !!}</span><br>
                                    @if(!empty($chat->replier_number))
                                    {!! Form::open(['route' => ['settingchatreply.show',$books->id,$chat->id]]) !!}
                                        <button class="btn btn-reply" type="button submit">{!! $chat->replier_number !!}件の返信</button>
                                    {!! Form::close() !!}
                                    @endif
                                    
                                    
                                    {!! Form::open(['route' => ['settingchatsreply.create',$books->id,$word->id,$chat->id]]) !!}
                                        <button class="nice unnice" type="button submit">返信する</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                <!--<div class="item" data-id="{{ $word->id }}">-->
                <!--    <div id="comment-data"></div>-->
                <!--</div>-->
                <br>
                <div class="col-lg-6">
                    {!! Form::open(['route' => ['settingchats.store',$books->id,$word->id]]) !!}
                    <div class="form-group">
                        <textarea name="content"  wrap="hard" cols="50" rows="5" id="word_chat_content_input" onkeyup="document.getElementById('xxxx').value=this.value.length"></textarea>
                        <p><input type="text" id="xxxx">/300</p>
                        <script>
                        function lineCheck(e) {
                            var ta = document.getElementById("word_chat_content_input");
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
                    </div>
                {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
                {!! Form::close() !!}
                </div>
            </div>
    </div>
    
@endsection