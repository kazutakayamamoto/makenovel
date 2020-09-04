@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <div class="row">
        <div class="box2 col-md-12">
            @if (count($sections) > 0)
                <ul class="list-unstyled">
                    @foreach ($sections as $section)
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
                                                    {!! Form::open(['route' => ['section.unnice', $section->id],'method' => 'delete']) !!}
                                                        {!! Form::submit('いいねを外す', ['class' => "btn btn-primary btn-block"]) !!}
                                                    {!! Form::close() !!}
                                                @else
                                                    {!! Form::open(['route' => ['section.nice', $section->id]]) !!}
                                                        {!! Form::submit('いいね', ['class' => "btn btn-primary btn-block"]) !!}
                                                    {!! Form::close() !!}
                                                @endif
                                            @endif
                                    </div>
                                </div>
                            </li>
                        </div>
                    @endforeach
                </ul>
            @endif            
        </div>
    </div>
    <div class="row">
        <div class="box2 col-md-12">
            {!! Form::open(['route' => 'sections.store']) !!}
            <div class="form-group box3">  
                {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => 'col-md-12']) !!}
                {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection