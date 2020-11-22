@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <div class="row">
        <div class="col-lg-12">
            
            <h3>{!! link_to_route('section.main', nl2br(e($books->title)),[$books->id]) !!}のメインページへ戻る</h3>
            <p>小説の登場人物や国などの組織、能力や武器、動物など様々な用語が並ぶページです。
            <br>用語をクリックすると詳細ページに飛べます。</p>
            語句の追加はメインページの様子を見てプロジェクトの作成者が行います。<br>
            @if (count($words) > 0)
                @foreach ($words as $word)
                        <p class="words_content">{!! link_to_route('words.show', nl2br(e($word->name)) , [$books->id,$word->id]) !!}</p>
                @endforeach
            @endif
            @if($books->user_id == \Auth::id())
                {!! Form::open(['route' => ['words.store',$books->id]]) !!}
                    <div class="form-group">
                        <textarea name="name" cols="50" rows="5" onkeyup="document.getElementById('zzzz').value=this.value.length"></textarea>
                        <p><input type="text" id="zzzz">/300</p>
                    </div>
                {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
                {!! Form::close() !!}
            @endif
        </div>
        </div>
@endsection