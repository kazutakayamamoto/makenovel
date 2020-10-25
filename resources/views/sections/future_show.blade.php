@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!--<div class="row">-->
    <!--        @if(!empty($section_tree))-->
    <!--            この節では{!! $section_tree->content !!}について書いてください。-->
    <!--        @endif-->
    <!--    <div class="box2 col-md-12">-->
    <!--        @foreach ($sections as $section)-->
    <!--            @if (count($sections) > 0)-->
    <!--                <ul class="list-unstyled">-->
    <!--                    <div class="box3">-->
    <!--                        <li class="media mb-3">-->
    <!--                            <div class="media-body">-->
    <!--                                <div>-->
    <!--                                    <p>-->
    <!--                                        {!! '名前:' !!}{!! $section->user->name !!}-->
    <!--                                        {!! 'いいねの数:' !!}{{$section->count_nice($section->id)}}-->
    <!--                                    </p>-->
    <!--                                    {{-- 投稿内容 --}}-->
    <!--                                    <p class="mb-0">{!! nl2br(e($section->content)) !!}</p>-->
    <!--                                        @if (Auth::id())-->
    <!--                                            @if ($section->is_nice($section->id,Auth::id()))-->
    <!--                                                {!! Form::open(['route' => ['section.unnice', $section->id],'method' => 'delete']) !!}-->
    <!--                                                    <button class="nice unnice" type="button submit">いいねを外す</button>-->
    <!--                                                {!! Form::close() !!}-->
    <!--                                            @else-->
    <!--                                                {!! Form::open(['route' => ['section.nice', $section->id]]) !!}-->
    <!--                                                    <button class="nice" type="button submit">いいね</button>-->
    <!--                                                {!! Form::close() !!}-->
    <!--                                            @endif-->
    <!--                                        @endif-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        </li>-->
    <!--                    </div>-->
    <!--                </ul>-->
    <!--            @endif            -->
    <!--        @endforeach-->
    <!--    </div>-->
    <!--</div>    -->
    <!--@if (Auth::id())-->
    <!--    <div class="row">-->
    <!--        <div class="box2 col-md-12">-->
    <!--            {!! Form::open(['route' => ['section.future_store']]) !!}-->
    <!--            <div class="form-group box3">  -->
    <!--                {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}-->
    <!--                {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}-->
    <!--            </div>-->
    <!--            {!! Form::close() !!}-->
    <!--        </div>-->
    <!--    </div>-->
    <!--@endif-->
@endsection