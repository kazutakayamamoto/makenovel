@extends('layouts.app')

@section('content')
            <p>小説の登場人物や国などの組織、能力や武器、動物など様々な用語が並ぶページです。
            <br>用語をクリックすると詳細ページに飛べます。</p>
            <div>
            {!! link_to_route('books.index','いいね管理テーブル') !!}
            @if (count($words) > 0)
                @foreach ($words as $word)
                        <p>{!! link_to_route('words.show', $word->name , ['word' => $word->id]) !!}</p>
            
                        {!! Form::open(['route' => ['words.destroy',$word->id]]) !!}
                        
                        {!! Form::submit('削除する', ['class' => 'btn btn-primary btn-block']) !!}
                        {!! Form::close() !!}

                        <!--{!! Form::open(['route' => ['words.update',$word->id]]) !!}-->
                        <!--    <div class="form-group">  -->
                        <!--        {!! Form::textarea('name', old('name'), ['class' => 'form-control']) !!}-->
                        <!--    </div>-->
                        <!--{!! Form::submit('文章を投稿する', ['class' => 'btn btn-primary btn-block']) !!}-->
                        <!--{!! Form::close() !!}-->

                @endforeach
            @endif
            </div>
            {!! Form::open(['route' => 'words.store']) !!}
                <div class="form-group">  
                    {!! Form::textarea('name', old('name'), ['class' => 'form-control']) !!}
                </div>
            <input class="btn btn-default form-control" type="submit" name="追加する">
            {!! Form::close() !!}
            
            <div>
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