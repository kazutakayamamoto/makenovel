@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @if (count($section_trees) > 0)
        @foreach ($section_trees as $section_tree)
            {!! $section_tree->content !!}
            <p>↓</p>
        @endforeach
    @endif

    {!! Form::open(['route' => 'section_trees.store']) !!}
        <div class="form-group">  
            {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}
        </div>
     </div>
    <input class="btn btn-default form-control" type="submit" name="追加する">
    {!! Form::close() !!}
@endsection


