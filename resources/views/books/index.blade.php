@extends('layouts.app')

@section('content')

    {!! Form::model($books, ['route' => ['books.update', $books->id], 'method' => 'put']) !!}
        <div class="form-group">
            <p>セクションいいねは{{$books->section_nice_number}}を超えると新しいセクションができます。</p>
            {!! Form::label('section_nice_number', 'セクションいいね:') !!}
            {!! Form::text('section_nice_number', null, ['class' => 'form-control']) !!}
            <p>設定いいねは{{$books->setting_nice_number}}を超えると新しい設定ができます。</p>
            {!! Form::label('setting_nice_number', '設定いいね:') !!}
            {!! Form::text('setting_nice_number', null, ['class' => 'form-control']) !!}
        </div>
        {!! Form::submit('更新', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

@endsection