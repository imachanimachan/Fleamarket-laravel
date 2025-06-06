<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body class="page">

    <header class="top-header">
        <div class="top-header__inner">
            <div class="top-header__logo">
                <img src="{{ asset('storage/logo/logo.svg') }}" alt="COACHTECH" class="top-header__logo-img">
            </div>
            <form class="top-header__search-form" action="" method="" enctype="multipart/form-data">
                @csrf
                <input type="text" class="top-header__search-input" placeholder="なにをお探しですか？">
            </form>
            <nav class="top-header__nav">
                <ul class="top-header__nav-list">
                    @auth
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button class="top-header__nav-link">ログアウト</button>
                        </form>
                    </li>
                    <li><a class="top-header__nav-item" href="/mypage">マイページ</a></li>
                    @else
                    <li><a class="top-header__nav-item" href="/login">ログイン</a></li>
                    <li><a class="top-header__nav-item" href="/login">マイページ</a></li>
                    @endauth
                    <li><a class="top-header__nav-item--white" href="#">出品</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

</body>

</html>