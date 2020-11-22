@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script type="module" src="/js/index.1.js"></script>
    <div class="row">
        <div>
        <h3>{!! link_to_route('section.main', nl2br(e($books->title)),[$books->id]) !!}のメインページへ戻る</h3>
        <p>ここには適当に思いついた展開とかこういう文章はどうかといった提案などを行う場所です。</p>
        <p>必ずしもここに書かれたものがメインページで使われるとは限りません。</p>
        </div>
        <div class="box2 col-lg-12">
                <div class="show_plus_section"><i class="far fa-2x fa-plus-square"></i>&nbsp;&nbsp;追加する</div>
                <div class="plus_section section_form">
                {!! Form::open(['route' => ['section.store2', $books->id,0]]) !!}
                    <br>
                    <div class="form-group">  
                            <textarea name="content" cols="60" rows="5" onkeyup="document.getElementById('xxxx').value=this.value.length"></textarea>
                            <p><input type="text" id="xxxx">/300</p>
                    </div>
                    伏線やこの文章の意味について説明する
                    <div class="form-group box4">
                            <textarea name="under_plot" cols="60" rows="5" onkeyup="document.getElementById('yyyy').value=this.value.length"></textarea>
                            <p><input type="text" id="yyyy">/300</p>  
                    </div>
                {!! Form::submit('投稿する', ['class' => 'unnice']) !!}
                {!! Form::close() !!}
                </div>
            @foreach ($sections as $section)
                @if (count($sections) > 0)
                    <ul class="list-unstyled">
                        <div class="box3">
                            <li class="media mb-3">
                                <div class="media-body">
                                    <div>
                                        <p>
                                            {!! '名前:' !!}{!! nl2br(e($section->user->name)) !!}
                                            {!! 'いいねの数:' !!}{{$section->count_nice($section->id)}}
                                        </p>
                                        {{-- 投稿内容 --}}
                                        <p class="mb-0">{!! nl2br(e($section->content)) !!}</p>
                                        @if(!empty($section->under_plot))
                                            <a class="underplot_show"><span>伏線を見る</span>
                                            <p class="underplot_content">{!! nl2br(e($section->under_plot)) !!}</p>
                                            </a>
                                        @endif
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
@endsection