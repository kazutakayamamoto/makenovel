@extends('layouts.app')

@section('content')
            <p>{!! link_to_route('section.main', nl2br(e($books->title)),[$books->id]) !!}のメインページへ戻る</p>
            <p>小説の登場人物や国などの組織、能力や武器、動物など様々な用語が並ぶページです。
            <br>用語をクリックすると詳細ページに飛べます。</p>
            語句の追加はメインページの様子を見て管理人が行います。<br>
            @if (count($words) > 0)
                @foreach ($words as $word)
                        <p>{!! link_to_route('words.show', $word->name , [$books->id,$word->id]) !!}</p>
                @endforeach
            @endif
            {!! Form::open(['route' => ['words.store',$books->id]]) !!}
                <div class="form-group">
                    <textarea name="name" cols="50" rows="5" onkeyup="document.getElementById('zzzz').value=this.value.length"></textarea>
                    <p><input type="text" id="zzzz">/300</p>
                </div>
            {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
@endsection