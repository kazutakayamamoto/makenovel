@extends('layouts.app')

@section('content')
            @if (count($words) > 0)
                @foreach ($words as $word)
                        <p>{!! link_to_route('words.show', $word->name , ['word' => $word->id]) !!}</p>
                @endforeach
            @endif

            {!! Form::open(['route' => 'words.store']) !!}
                <div class="form-group">  
                    {!! Form::textarea('name', old('name'), ['class' => 'form-control']) !!}
                </div>
             </div>
            <input class="btn btn-default form-control" type="submit" name="追加する">
            {!! Form::close() !!}
@endsection