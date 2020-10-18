@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <div class="row">
        {!! link_to_route('section_trees.index', 'セクションツリーに戻る', ['class' => 'btn btn-primary']) !!}
        <div class="box2 col-md-12">
            @foreach ($section_trees as $section_tree)
                    <ul class="list-unstyled">
                        <div class="box3">
                            <li class="media mb-3">
                                <div class="media-body">
                                    <div>
                                        <p>
                                            {!! '名前:' !!}{!! $section_tree->user->name !!}
                                            {!! 'いいねの数:' !!}{{$section_tree->count_nice($section_tree->id)}}
                                        </p>
                                        {{-- 投稿内容 --}}
                                        <p class="mb-0">{!! nl2br(e($section_tree->content)) !!}</p>
                                            @if (Auth::id())
                                                @if ($section_tree->is_nice($section_tree->id,Auth::id()))
                                                    {!! Form::open(['route' => ['section_tree.unnice', $section_tree->id],'method' => 'delete']) !!}
                                                        {!! Form::submit('いいねを外す', ['class' => "btn btn-primary btn-block"]) !!}
                                                    {!! Form::close() !!}
                                                @else
                                                    {!! Form::open(['route' => ['section_tree.nice', $section_tree->id]]) !!}
                                                        {!! Form::submit('いいね', ['class' => "btn btn-primary btn-block"]) !!}
                                                    {!! Form::close() !!}
                                                @endif
                                            @endif
                                    </div>
                                </div>
                            </li>
                        </div>
                    </ul>
            @endforeach
        </div>
    </div>
    {!! Form::open(['route' => ['section_trees.store2',$section_tree->section_number]]) !!}
        <div class="form-group">  
            {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}
        </div>
     </div>
    <input class="btn btn-default form-control" type="submit" name="追加する">
    {!! Form::close() !!}
@endsection