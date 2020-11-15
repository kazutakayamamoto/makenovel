@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<script type="text/javascript">
  var bookid = {{$books->id}};
</script>
<script type="module" src="/js/index.js"></script>
    <p>メインページ</p>
    {!! link_to_route('words.index', 'この小説の設定一覧',[$books->id]) !!}&nbsp;&nbsp;
    <i class="fas fa-tree"></i>{!! link_to_route('section_trees.index', 'セクションツリー', ['bookid'=>$books->id]) !!}
    <div class="row">
        <div class="box2 col-lg-6">
            <p>ここに1つの小説ができていきます。</p>
            <p>300文字づつ節ごとに一番いい文章を選ぶという感じです。</p>
            <p>節ごとにもっといい文章をほかの案を見るで投稿してください。</p>
            <p>ほかの案を見るでこの節のよりよい案を投稿し、いいねが多ければその節の文章が変わります。</p>
            {!! link_to_route('section.futuresh', 'この先で使ってほしい展開文章',[$books->id]) !!}
            <br>
            @for ($i = 1; $i < $max_section_number; $i++)
                @foreach ($sections->where('section_number',$i) as $section)
                    @if (count($sections) > 0)
                        <ul class="list-unstyled">
                            <div class="box3">
                                <li class="media mb-3">
                                    <div class="media-body">
                                        <div>
                                            <p>
                                                {!! $i. '節' !!}
                                                名前:{!! $section->user->name !!}
                                                いいねの数:{{$section->nices_count}}
                                            </p>
                                            {{-- 投稿内容 --}}
                                            <p class="mb-0">{!! nl2br(e($section->content)) !!}</p><br>
                                            @if(!empty($section->under_plot))
                                                <a class="underplot_show"><span>伏線を見る</span>
                                                <p class="underplot_content">{!! nl2br(e($section->under_plot)) !!}</p>
                                                </a><br><br>
                                            @endif
                                                 {!! link_to_route('sections.show', '他の案を見る',['bookid'=>$books->id,'section'=>$section->section_number],[]) !!}
                                        </div>
                                    </div>
                                </li>
                            </div>
                        </ul>
                    @endif            
                    @break    
                @endforeach
            @endfor
        </div>
        <div class="box2 col-lg-6">
            <p>ここが最新節です。続きを書くときはここに書いてください。いいねが{!! $books->section_nice_number !!}を超えると節が移ります。</p>
            <div>
            @if(!empty($section_tree))
                節題:{!! link_to_route('section_trees.index', $section_tree->content,[$books->id]) !!}
            @endif
            </div>
            <br>
            <div>

            
            <div class="show_plus_section"><i class="far fa-2x fa-plus-square"></i>&nbsp;&nbsp;追加する</div>
            
            <div class="plus_section">
                <div class="box5 col-lg-12">
                    <br>
                    {!! Form::open(['route' => ['sections.store',$books->id]]) !!}
                    <div class="form-group">  
                            <textarea name="content" cols="50" rows="5" wrap="hard" placeholder="300文字で節題に合う文章を投稿してください" onkeyup="document.getElementById('xxxx').value=this.value.length"></textarea>
                            <input type="text" id="xxxx">/300
                    </div>
                    <p><input type="checkbox" name="check" value="prop" id="prop">：伏線アリならチェックを入れる</p>
                    <div class="form-group box4">
                            <textarea name="under_plot" cols="50" rows="5" wrap="hard" placeholder="300文字でこの文章の意図や伏線などについて説明できます。" onkeyup="document.getElementById('yyyy').value=this.value.length"></textarea>
                            <input type="text" id="yyyy">/300  
                    </div>
                 </div>
            {!! Form::submit('文章を投稿する', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
            </div>
            </div>

            <div class="box2_under">
            <!--<div class="up"><i class="fas fa-2x fa-chevron-up"></i></div>-->
            @foreach ($new_sections as $section)
                @if (count($new_sections) > 0)
                    <ul class="list-unstyled">
                        
                        <div class="box3">
                            
                            <li class="media mb-3">
                                <div class="media-body">
                                    <div>
                                        <p>
                                            {!! '名前:' !!}{!! $section->user->name !!}
                                            {!! 'いいねの数:' !!}{{$section->count_nice($section->id)}}
                                        </p>
                                        <p>{!! '投稿時間:' !!}{!! $section->created_at!!}</p>
                                        
                                        {{-- 投稿内容 --}}
                                        <p class="mb-0">{!! nl2br(e($section->content)) !!}</p>
                                        <br>
                                        @if(!empty($section->under_plot))
                                                <a class="underplot_show"><span>伏線を見る</span>
                                                <p class="underplot_content">{!! nl2br(e($section->under_plot)) !!}</p>
                                                </a>
                                        @endif
                                        
                                            @if ($section->is_nice($section->id,Auth::id()))
                                                {!! Form::open(['route' => ['section.unnice',$books->id ,$section->id],'method' => 'delete']) !!}
                                                    <button class="nice unnice" type="button submit">いいねを外す</button>
                                                {!! Form::close() !!}
                                            @else
                                                {!! Form::open(['route' => ['section.nice',$books->id,$section->id]]) !!}
                                                    <button class="nice" type="button submit">いいね</button>
                                                {!! Form::close() !!}
                                            @endif
                                    </div>
                                </div>
                            </li>
                        </div>
                    </ul>
                @endif            
            @endforeach
            </div>
        </div>
    </div>

        <!--チャットここから-->
        <div class="row">
            <div class="col-lg-10 chat-comment">
            最新の10件のチャット&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fas fa-arrow-alt-circle-up"></i>{!! link_to_route('chats.index', '過去のチャットを見る',[$books->id],['class' => 'btn btn-primary']) !!}
                <div id="comment-data">

                </div>
                <br>
                @if (Auth::id())
                        {!! Form::open(['route' => ['chats.store',$books->id]]) !!}
                        <div class="form-group">
                            <textarea onpaste="alert('ペースト禁止です'); return false;" name="content" id="chat_content_input" cols="50" rows="5"  wrap="off" onkeyup="document.getElementById('zzzz').value=this.value.length"></textarea>
                            <p><input type="text" id="zzzz">/300</p>
                            
                            <script>
                            function lineCheck(e) {
                                var ta = document.getElementById("chat_content_input");
                                var row = ta.getAttribute("rows");
                                var r = (ta.value.split("\n")).length;
                                if (document.all) {
                                    if (r >= row && window.event.keyCode === 13) { //keyCode for IE
                                        return false; //入力キーを無視
                                    }
                                } else {
                                    if (r >= row && e.which === 13) { //which for NN
                                        return false;
                                    }
                                }
                            }
                            window.document.onkeypress = lineCheck;
                            </script>
                        
                        </div>
                    <div class="col-lg-5">
                    {!! Form::submit('投稿する', ['class' => 'btn btn-primary btn-block']) !!}
                    </div>
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
@endsection


