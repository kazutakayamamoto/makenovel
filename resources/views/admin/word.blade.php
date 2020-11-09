@extends('layouts.app')

@section('content')
            @if (count($users) > 0)
                @foreach ($users as $user)
                        {!! $user -> name!!}
                        @if ($user->is_black($user->id))
                        {!! Form::open(['route' => ['destroy.blacklist',$user->id]]) !!}
                            {!! Form::submit('ブラックリストから外す', ['class' => 'btn btn-primary btn-block']) !!}
                        {!! Form::close() !!}
                        @else
                        {!! Form::open(['route' => ['user.blacklist',$user->id]]) !!}
                            {!! Form::submit('ブラックリストに登録', ['class' => 'btn btn-primary btn-block']) !!}
                        {!! Form::close() !!}
                        @endif
                @endforeach
            @endif
            </div>            
@endsection