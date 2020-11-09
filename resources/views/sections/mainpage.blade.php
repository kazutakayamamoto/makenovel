@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <div class="row">
        進行中のプロジェクト
        <div class="box2 col-lg-12">
            <ul>
            @foreach ($books as $book)
                @if (count($books) > 0)
                    <li><p>{!! link_to_route('section.main', nl2br(e($book->title)),[$book->id]) !!}</p>
                    {!! nl2br(e($book->subject)) !!}
                    </li>    
                @endif            
            @endforeach
            </ul>
        </div>
    </div>    
@endsection