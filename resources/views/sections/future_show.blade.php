@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <div class="row">
        <p>{!! link_to_route('section.main', nl2br(e($books->title)),[$books->id]) !!}のメインページへ戻る</p>
        <p>ここには適当に思いついた展開とかこういう文章はどうかといった提案などを行う場所です。</p>
        <p>必ずしもここに書かれたものがメインページで使われるとは限りません。</p>
        <div class="box2 col-lg-12">
            @foreach ($sections as $section)
                @if (count($sections) > 0)
                    <ul class="list-unstyled">
                        <div class="box3">
                            <li class="media mb-3">
                                <div class="media-body">
                                    <div>
                                        <p>
                                            {!! '名前:' !!}{!! $section->user->name !!}
                                            {!! 'いいねの数:' !!}{{$section->count_nice($section->id)}}
                                        </p>
                                        {{-- 投稿内容 --}}
                                        <p class="mb-0">{!! nl2br(e($section->content)) !!}</p>
                                            @if (Auth::id())
                                                @if ($section->is_nice($section->id,Auth::id()))
                                                    {!! Form::open(['route' => ['section.unnice',$books->id,$section->id],'method' => 'delete']) !!}
                                                        <button class="nice unnice" type="button submit">いいねを外す</button>
                                                    {!! Form::close() !!}
                                                @else
                                                    {!! Form::open(['route' => ['section.nice',$books->id,$section->id]]) !!}
                                                        <button class="nice" type="button submit">いいね</button>
                                                    {!! Form::close() !!}
                                                @endif
                                            @endif
                                    </div>
                                </div>
                            </li>
                        </div>
                    </ul>
                @endif            
            @endforeach
        </div>
    </div>    
    
        <div class="row">
            <div class="box2 col-lg-12">
                <br>
                {!! Form::open(['route' => ['section.futurest',$books->id]]) !!}
                        <div class="form-group">
                            <textarea name="content" id="chat_content_input" cols="50" rows="5" onkeyup="document.getElementById('zzzz').value=this.value.length"></textarea>
                            <p><input type="text" id="zzzz">/300</p>
                            
                        
                        </div>
                <div class="col-lg-4">
                {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>

@endsection