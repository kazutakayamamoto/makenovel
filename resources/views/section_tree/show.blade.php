@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script type="module" src="/js/index.1.js"></script>    
    <div class="row"]
        <div class="section_tree_show_wrapper">
        <div>
        <h3>{!! link_to_route('section.main', nl2br(e($books->title)),[$books->id]) !!}のメインページへ戻る</h3>
        <p>{!! link_to_route('section_trees.index', 'セクションツリーに戻る', [$books->id]) !!}</p>
        </div>
        <div class="box2 col-lg-12">
        
            {{ $section_trees->first()->section_number }}節の節題
            
            <div class="show_plus_section"><i class="far fa-2x fa-plus-square"></i>&nbsp;&nbsp;追加する</div>
            {!! Form::open(['route' => ['section_trees.store2',$books->id,$section_number]]) !!}
                <div class="form-group setting-form">
                    <textarea name="content" cols="50" rows="4"  wrap="hard" onkeyup="document.getElementById('zzzz').value=this.value.length" placeholder="50文字以内で節の内容を記述してください。"></textarea>
                    <p><input type="text" id="zzzz">/50</p>
                     {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
                </div>
            {!! Form::close() !!}
            
            @foreach ($section_trees as $section_tree)
                    <ul class="list-unstyled">
                        <div class="box3">
                            <li class="media mb-3">
                                <div class="media-body">
                                    <div>
                                        <p>
                                            {!! '名前:' !!}{!! nl2br(e($section_tree->user->name)) !!}
                                            {!! 'いいねの数:' !!}{{$section_tree->count_nice($section_tree->id)}}
                                        </p>
                                        {{-- 投稿内容 --}}
                                        <p class="mb-0">{!! nl2br(e($section_tree->content)) !!}</p>
                                            @if($section_tree->user_id!=1)
                                                @if ($section_tree->is_nice($section_tree->id,Auth::id()))
                                                    {!! Form::open(['route' => ['section_tree.unnice',$books->id,$section_tree->id],'method' => 'delete']) !!}
                                                        <button class="nice unnice" type="button submit">いいねを外す</button>
                                                    {!! Form::close() !!}
                                                @else
                                                    {!! Form::open(['route' => ['section_tree.nice',$books->id, $section_tree->id]]) !!}
                                                        <button class="nice" type="button submit">いいね</button>
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
    </div>
@endsection