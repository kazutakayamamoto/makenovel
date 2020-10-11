@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script type="module" src="/js/index.js"></script>
    {!! link_to_route('words.index', 'この小説の設定一覧', ['class' => 'btn btn-primary']) !!}
    <div class="row">
        <div class="box2 col-md-6">
            <p>採用された文章一覧</p>
            {!! link_to_route('sections.show', 'この先で使ってほしい文章', ['section'=>0], ['class' => 'btn btn-primary']) !!}<br>
            @for ($i = 1; $i < $max_section_number; $i++)
                @foreach ($sections->where('section_number',$i) as $section)
                    @if (count($sections) > 0)
                        <ul class="list-unstyled">
                            <div class="box3">
                                <li class="media mb-3">
                                    <div class="media-body">
                                        <div>
                                            <p>
                                                {!! $i. '節' !!}
                                                名前:{!! $section->user->name !!}
                                                いいねの数:{{$section->nices_count}}
                                            </p>
                                            {{-- 投稿内容 --}}
                                            <p class="mb-0">{!! nl2br(e($section->content)) !!}</p>
                                                 {!! link_to_route('sections.show', 'Anotheridea', ['section'=>$section->section_number], ['class' => 'btn btn-primary']) !!}
                                        </div>
                                    </div>
                                </li>
                            </div>
                        </ul>
                    @endif            
                    @break    
                @endforeach
            @endfor
        </div>

        <div class="box2 col-md-6">
            <div>
            <a href="/?sort=new">新しい順</a>
            <a href="/?sort=nice">いいね順</a>
            @if (Auth::id())
            <div class="show_plus_section"><i class="far fa-2x fa-plus-square"></i></div>追加する
            
            <div class="row plus_section">
                <div class="box5 col-md-12">
                    {!! Form::open(['route' => 'sections.store']) !!}
                    <div class="form-group">  
                            <textarea name="content" cols="50" rows="10" onkeyup="document.getElementById('xxxx').value=this.value.length"></textarea>
                            <input type="text" id="xxxx">/300
                    </div>
                    <p><input type="checkbox" name="check" value="prop" id="prop">：伏線アリならチェックを入れる</p>
                    <div class="form-group box4">  
                        {!! Form::textarea('under_plot', old('content'), ['class' => 'form-control']) !!}
                    </div>
                 </div>
            {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
            </div>
            @endif
            
            </div>
            <div class="box2_under">
            <div class="up"><i class="fas fa-2x fa-chevron-up"></i></div>
            @foreach ($new_sections as $section)
                @if (count($new_sections) > 0)
                    <ul class="list-unstyled">
                        
                        <div class="box3">
                            
                            <li class="media mb-3">
                                <div class="media-body">
                                    <div>
                                        <p>
                                            {!! '名前:' !!}{!! $section->user->name !!}
                                            {!! 'いいねの数:' !!}{{$section->count_nice($section->id)}}
                                        </p>
                                        <p>{!! '投稿時間:' !!}{!! $section->created_at!!}</p>
                                        <p>{!! 'id:' !!}{!! $section->id!!}</p>
                                        
                                        {{-- 投稿内容 --}}
                                        <p class="mb-0">{!! nl2br(e($section->content)) !!}</p>
                                            @if (Auth::id())
                                                @if ($section->is_nice($section->id,Auth::id()))
                                                    {!! Form::open(['route' => ['section.unnice', $section->id],'method' => 'delete']) !!}
                                                        <button class="nice unnice" type="button submit">いいねを外す</button>
                                                    {!! Form::close() !!}
                                                @else
                                                    {!! Form::open(['route' => ['section.nice', $section->id]]) !!}
                                                        <button class="nice" type="button submit">いいね</button>
                                                    {!! Form::close() !!}
                                                @endif
                                            @endif
                                        @if(!empty($section->under_plot))
                                                <a class="underplot_show"><span>伏線を見る</span>
                                                <p class="underplot_content">{!! nl2br(e($section->under_plot)) !!}</p>
                                                </a>
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
    </div>

        <!--チャットここから-->
        <div class="row">
            <div class="col-md-12"> 
                <div id="comment-data"></div>
                @if (Auth::id())
                    <div class="col-md-6">
                        {!! Form::open(['route' => 'chats.store']) !!}
                        <div class="form-group box3">
                            {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}
                        </div>
                    {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
                    {!! Form::close() !!}
                    </div>
                @endif
            </div>
        </div>
@endsection


