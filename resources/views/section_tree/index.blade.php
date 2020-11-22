@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <h3>{!! link_to_route('section.main', nl2br(e($books->title)),[$books->id]) !!}のメインページへ戻る</h3>
    <p>ここでは50字までの短い文章でこの物語の方向性を決定していきます。</p>
    <p>メインページやほかの案を見るでの節題はここの文章が採用されるので先にここを進めてください。</p>
    <p>メインページの内容が軽くわかるような感じにしたいです。</p>
    <p>いいねが{{$books->section_nice_number}}を超えると次のセクションツリーができます。</p>
    <div class="row">
         <div class="col-sm-12">
            @for ($i = 1; $i < $max_section_number+1; $i++)
                    @foreach ($section_trees->where('section_number',$i) as $section_tree)
                        <p class="section_tree_leaf col-sm-10">{!! $section_tree->section_number !!}.{!! nl2br(e($section_tree->content)) !!}
                        <br>
                        {!! link_to_route('section_trees.show','他の案を見る', [$books->id,$section_tree->section_number],['class' => 'section_tree_another']) !!}
                        </p>
                        
                        <i class="fas fa-2x fa-arrow-down"></i>
                        @if($number==$section_tree->section_number)
                        ←<font color="red">いまここまでが文章の最新節です。</font>
                        @endif
                        
                        @break;
                    @endforeach
            @endfor
        </div>
    </div>
@endsection


