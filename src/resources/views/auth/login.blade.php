<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
</head>

<body class="page">
    <header class="top-header">
        <div class="top-header__inner">
            <div class="top-header__logo">
                <a href="/">
                    <img src="{{ asset('storage/logo/logo.svg') }}" alt="COACHTECH" class="top-header__logo-img">
                </a>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="login">
            <h2 class="login__title">ログイン</h2>
            <form class="login__form" method="POST" action="/login">
                @csrf
                <label class="login__label">メールアドレス
                    <input type="email" name="email" class="login__input" value="{{ old('email') }}">
                    @error('email')
                    <p class="login__error">{{ $message }}</p>
                    @enderror
                </label>
                <label class="login__label">パスワード
                    <input type="password" name="password" class="login__input" value="{{ old('password') }}">
                    @error('password')
                    <p class="login__error">{{ $message }}</p>
                    @enderror
                </label>
                <button class="login__button" type="submit">ログインする</button>
            </form>
            <a class="login__link" href="/register">会員登録はこちら</a>
        </div>
    </main>
</body>

</html>