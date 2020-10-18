@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script type="module" src="/js/words_show.js"></script>
    {!! link_to_route('words.index', '設定一覧に戻る', ['class' => 'btn btn-primary']) !!}
    <p>{!! '名前:' !!}{!! $word->name !!}</p>
    <div class="row">
        
        <div class="box2 col-md-6">
            {!! 'いいねが1を超えたもの' !!}
            @if (count($settings_adapt) > 0)
                @foreach ($settings_adapt as $setting)
                    <div class="box3">
                        <p class="mb-0">{!! nl2br(e($setting->content)) !!}</p>
                        {!! 'いいねの数:' !!}{{$setting->nices_count}}
                        @if (Auth::id())
                            @if ($setting->is_nice($setting->id,Auth::id()))
                                {!! Form::open(['route' => ['setting.unnice', $setting->id],'method' => 'delete']) !!}
                                    {!! Form::submit('いいねを外す', ['class' => "btn btn-primary btn-block"]) !!}
                                {!! Form::close() !!}
                            @else
                                {!! Form::open(['route' => ['setting.nice', $setting->id]]) !!}
                                    {!! Form::submit('いいね', ['class' => "btn btn-primary btn-block"]) !!}
                                {!! Form::close() !!}
                            @endif
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        <div class="box2 col-md-6">
            @if (count($settings_stay) > 0)
                @foreach ($settings_stay as $setting)
                <div class="box3">
                    <p class="mb-0">{!! nl2br(e($setting->content)) !!}</p>
                    {!! 'いいねの数:' !!}{{$setting->nices_count}}
                    @if (Auth::id())
                        @if ($setting->is_nice($setting->id,Auth::id()))
                            {!! Form::open(['route' => ['setting.unnice', $setting->id],'method' => 'delete']) !!}
                                {!! Form::submit('いいねを外す', ['class' => "btn btn-primary btn-block"]) !!}
                            {!! Form::close() !!}
                        @else
                            {!! Form::open(['route' => ['setting.nice', $setting->id]]) !!}
                                {!! Form::submit('いいね', ['class' => "btn btn-primary btn-block"]) !!}
                            {!! Form::close() !!}
                        @endif
                    @endif
                </div>
                @endforeach
            @endif
        </div>
        {!! Form::open(['route' => ['settings.store', $word->id]]) !!}
            <div class="form-group">  
                {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}
            </div>
        <input class="btn btn-default form-control" type="submit" name="追加する">
        {!! Form::close() !!}
    </div>
    
    
    
        <!--チャットここから-->
    <div class="row">
        <div class="col-md-12">
             <div class="item" data-id="{{ $word->id }}">
                <div id="comment-data"></div>
            </div>
        
            <div class="col-md-6">
                {!! Form::open(['route' => ['settingchats.store', $word->id]]) !!}
                <div class="form-group box3">  
                    {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}
                </div>
            {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection