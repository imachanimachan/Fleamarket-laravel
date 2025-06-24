<?php

namespace Tests;
use Laravel\Fortify\Features;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
{
    parent::setUp();

    config(['fortify.features' => [
        Features::registration(),
        // Features::emailVerification(), ← コメントアウト
    ]]);

    // Fortifyの登録ルートを再読み込み（メール認証無効の設定を反映させるため）
    $this->app->register(\Laravel\Fortify\FortifyServiceProvider::class);
}
}
