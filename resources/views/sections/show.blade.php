@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script type="module" src="/js/index.1.js"></script>
    <div class="row">
            @if(!empty($section_tree))
                節題:{!! link_to_route('section_trees.index', $section_tree->content, ['class' => 'btn btn-primary']) !!}
            @endif
        <div class="box2 col-md-12">
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
                                        
                                        @if(!empty($section->under_plot))
                                            <a class="underplot_show"><span>伏線を見る</span>
                                            <p class="underplot_content">{!! nl2br(e($section->under_plot)) !!}</p>
                                            </a>
                                        @endif

                                        @if ($section->is_nice($section->id,Auth::id()))
                                            {!! Form::open(['route' => ['section.unnice', $section->id],'method' => 'delete']) !!}
                                                <button class="nice unnice" type="button submit">いいねを外す</button>
                                            {!! Form::close() !!}
                                        @else
                                            {!! Form::open(['route' => ['section.nice', $section->id]]) !!}
                                                <button class="nice" type="button submit">いいね</button>
                                            {!! Form::close() !!}
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
            <div class="box2 col-md-12">
                @if (count($sections) > 0)
                {!! Form::open(['route' => ['section.store2', $section->section_number]]) !!}
                @else
                {!! Form::open(['route' => ['section.store2', 0]]) !!}
                @endif
                <div class="box5 col-md-12">
                    <br>
                    {!! Form::open(['route' => 'sections.store']) !!}
                    <div class="form-group">  
                            <textarea name="content" cols="60" rows="5" onkeyup="document.getElementById('xxxx').value=this.value.length"></textarea>
                            <p><input type="text" id="xxxx">/300</p>
                    </div>
                    伏線やこの文章の意味について説明する
                    <div class="form-group box4">
                            <textarea name="under_plot" cols="60" rows="5" onkeyup="document.getElementById('yyyy').value=this.value.length"></textarea>
                            <p><input type="text" id="yyyy">/300</p>  
                    </div>

                <div class="col-md-5">
                {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
                </div>

                </div>
            {!! Form::close() !!}
            </div>
                {!! Form::close() !!}
            </div>
        </div>
@endsection