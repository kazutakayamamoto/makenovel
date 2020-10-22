@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<script type="module" src="/js/words_show.js"></script>
<script type="module" src="/js/index.1.js"></script>

    {!! link_to_route('words.index', '設定一覧に戻る', ['class' => 'btn btn-primary']) !!}
    <p>{!! '名前:' !!}{!! $word->name !!}</p>
    <div class="row">
        
        <div class="box2 col-md-6">
            {!! 'いいねが1を超えたもの' !!}
            @if (count($settings_adapt) > 0)
                @foreach ($settings_adapt as $setting)
                    <div class="box3">
                        名前:{!! nl2br(e($setting->user->name)) !!}
                        <!--{!! 'いいねの数:' !!}{{$setting->nices_count}}-->
                        <p class="mb-0">{!! nl2br(e($setting->content)) !!}</p>
                        
                        @if ($setting->is_nice($setting->id,Auth::id()))
                            {!! Form::open(['route' => ['setting.unnice', $setting->id],'method' => 'delete']) !!}
                                <button class="nice unnice" type="button submit">いいねを外す</button>
                            {!! Form::close() !!}
                        @else
                            {!! Form::open(['route' => ['setting.nice', $setting->id]]) !!}
                                <button class="nice" type="button submit">いいね</button>
                            {!! Form::close() !!}
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        <div class="box2 col-md-6">
            
            <div class="show_plus_section"><i class="far fa-2x fa-plus-square"></i>&nbsp;&nbsp;追加する</div>
            {!! Form::open(['route' => ['settings.store', $word->id]]) !!}
                <div class="form-group setting-form">
                    <textarea name="content" cols="60" rows="5" onkeyup="document.getElementById('yyyy').value=this.value.length"></textarea>
                    <input type="text" id="yyyy">/300
                    <p></p>
                    {!! Form::submit('設定を投稿する', ['class' => 'btn btn-primary btn-block']) !!}
                    {!! Form::close() !!}
                </div>
            @if (count($settings_stay) > 0)
                @foreach ($settings_stay as $setting)
                <div class="box3">
                    名前:{!! nl2br(e($setting->user->name)) !!}
                    <!--{!! 'いいねの数:' !!}{{$setting->nices_count}}-->
                    <p class="mb-0">{!! nl2br(e($setting->content)) !!}</p>
                    @if ($setting->is_nice($setting->id,Auth::id()))
                        {!! Form::open(['route' => ['setting.unnice', $setting->id],'method' => 'delete']) !!}
                            <button class="nice unnice" type="button submit">いいねを外す</button>
                        {!! Form::close() !!}
                    @else
                        {!! Form::open(['route' => ['setting.nice', $setting->id]]) !!}
                            <button class="nice" type="button submit">いいね</button>
                        {!! Form::close() !!}
                    @endif
                </div>
                @endforeach
            @endif
            
        </div>
    </div>
    
    
    
        <!--チャットここから-->
    <div class="row">
        <div class="col-md-12">
            <p>{!! $word->name !!}について語るスレ</p>
            <div class="item" data-id="{{ $word->id }}">
                <div id="comment-data"></div>
            </div>
            <br>
            <div class="col-md-6">
                {!! Form::open(['route' => ['settingchats.store', $word->id]]) !!}
                <div class="form-group">  
                    <textarea name="content" cols="60" rows="5" onkeyup="document.getElementById('xxxx').value=this.value.length"></textarea>
                    <p><input type="text" id="xxxx">/300</p>
                </div>
            {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    
@endsection