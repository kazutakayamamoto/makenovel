@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script type="module" src="/js/hyouji.js"></script>
    <div class="row">
        <div class="box2 col-md-6">
            @for ($i = 1; $i < $max_section_number; $i++)
                {!! $i. '節' !!}
                @foreach ($sections->where('section_number',$i) as $section)
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
            
            <a href="/?sort=new">新しい順</a>
            <a href="/?sort=nice">いいね順</a>
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
                                                        {!! Form::submit('いいねを外す', ['class' => "btn btn-primary btn-block"]) !!}
                                                    {!! Form::close() !!}
                                                @else
                                                    {!! Form::open(['route' => ['section.nice', $section->id]]) !!}
                                                        {!! Form::submit('いいね', ['class' => "btn btn-primary btn-block"]) !!}
                                                    {!! Form::close() !!}
                                                @endif
                                            @endif
                                        @if(!empty($section->under_plot))
                                                <a class="underplot_show">伏線を見る
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
        @if (Auth::id())
        <div class="row">
            <div class="box5 col-md-12">
                {!! Form::open(['route' => 'sections.store']) !!}
                <div class="form-group box3">  
                    {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}
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

        <!--チャットここから-->
        <div class="chat-container row justify-content-center">
            <div class="chat-area">
                <div class="card">
                    <div class="card-header">Comment</div>
                    <div class="card-body chat-card">
                        <div id="comment-data"></div>
                    </div>
                </div>
            </div>
        </div>
        @if (Auth::id())
        <div class="row">
            <div class="box5 col-md-12">
                {!! Form::open(['route' => 'chats.store']) !!}
                <div class="form-group box3">  
                    {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}
                </div>
             </div>
        {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
        {!! Form::close() !!}
        </div>
        @endif
@endsection