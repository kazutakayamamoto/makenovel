@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @for ($i = 1; $i < $max_section_number+1; $i++)
            @foreach ($section_trees->where('section_number',$i) as $section_tree)
                <p>{!! $section_tree->content !!}</p>
                ↓
                @if($number==$section_tree->section_number)
                ←<font color="red">いまここ</font>
                @endif
                {!! link_to_route('section_trees.show','AnotherIdea', ['id' => $section_tree->section_number],['class' => 'section_tree_another']) !!}
                @break;
            @endforeach
    @endfor
    <!--{!! Form::open(['route' => 'section_trees.store']) !!}-->
    <!--    <div class="form-group">  -->
    <!--        {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}-->
    <!--    </div>-->
    <!-- </div>-->
    <!--<input class="btn btn-default form-control" type="submit" name="追加する">-->
    <!--{!! Form::close() !!}-->
@endsection


