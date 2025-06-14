<?php

namespace App\Http\Middleware;

//use Closure;
//use Illuminate\Http\Request;
//use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class Authenticate extends Middleware
{
    /**
     * 未認証ユーザーがアクセスした場合のリダイレクト先
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            return route('login'); // ルート名 'login' に未ログイン時リダイレクト
        }

        return null;
    }
}
