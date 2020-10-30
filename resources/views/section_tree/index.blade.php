@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <p>ここでは50字までの短い文章でこの物語の方向性を決定していきます。</p>
    <p>いいねが{{$books->section_nice_number}}を超えると次のセクションツリーができます。</p>
    <div class="row">
         <div class="col-sm-10">
            @for ($i = 1; $i < $max_section_number+1; $i++)
                    @foreach ($section_trees->where('section_number',$i) as $section_tree)
                        <p class="section_tree_leaf col-sm-10">{!! $section_tree->section_number !!}.{!! $section_tree->content !!}
                        <br>
                        {!! link_to_route('section_trees.show','他の案を見る', ['id' => $section_tree->section_number],['class' => 'section_tree_another']) !!}
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
    <!--{!! Form::open(['route' => 'section_trees.store']) !!}-->
    <!--    <div class="form-group">  -->
    <!--        {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}-->
    <!--    </div>-->
    <!-- </div>-->
    <!--<input class="btn btn-default form-control" type="submit" name="追加する">-->
    <!--{!! Form::close() !!}-->
@endsection


