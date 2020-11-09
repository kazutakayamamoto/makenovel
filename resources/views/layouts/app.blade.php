<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>みんなで小説を作ろう</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    </head>

    <body>
        <header class="mb-4">
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                {{-- トップページへのリンク --}}
                <a class="navbar-brand" href="/">みんなで小説を作ろう</a>

                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
                    <span class="navbar-toggler-icon">
                        
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="nav-bar">
                    <ul class="navbar-nav mr-auto">
                        <li>{!! link_to_route('makenovel.rule', '利用規約') !!}</li>
                        <li>{!! link_to_route('users.index', 'ユーザーページ', ['class' => 'btn btn-primary']) !!}</li>
                    </ul>
                    <ul class="navbar-nav">
                        
                         @if (Auth::check())
                            {{-- ログアウトへのリンク --}}
                            <li class="nav-item">{!! link_to_route('logout.get', 'Logout', [], ['class' => 'nav-link']) !!}</li>
                        @else
                            {{-- ユーザ登録ページへのリンク --}}
                            <li class="nav-item">{!! link_to_route('signup.get', 'Signup', [], ['class' => 'nav-link']) !!}</li>
                            {{-- ログインページへのリンク --}}
                            <li class="nav-item">{!! link_to_route('login', 'Login', [], ['class' => 'nav-link']) !!}</li>
                        @endif
                    </ul>
                </div>
            </nav>
        </header>

        <div class="container">
            @include('commons.error_messages')
            @yield('content')
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    </body>
</html>