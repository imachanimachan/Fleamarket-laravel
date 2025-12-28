@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/trade/index.css')}}">
@endsection

@section('content')
    <div class="trade">
        <div class="trade__container">
            <div class="trade__sidebar">
                <p class="trade__sidebar-title">その他の取引</p>
                <ul class="trade__item-list">
                    <li class="trade__item">商品名</li>
                    <li class="trade__item">商品名</li>
                    <li class="trade__item">商品名</li>
                </ul>
            </div>

            <div class="trade__main">
                <div class="trade__header">
                    <div class="trade__user">
                        <div class="trade__user-icon"></div>
                        <p class="trade__user-name">「ユーザー名」さんとの取引画面</p>
                    </div>
                </div>

                <div class="trade__product">
                    <div class="trade__product-image"></div>
                    <div class="trade__product-info">
                        <p class="trade__product-name">商品名</p>
                        <p class="trade__product-price">商品価格</p>
                    </div>
                </div>

                <div class="trade__chat">
                    <div class="trade__message trade__message--other">
                        <div class="trade__message-icon"></div>
                        <div class="trade__message-body">
                            <p class="trade__message-user">ユーザー名</p>
                            <div class="trade__message-text"></div>
                        </div>
                    </div>

                    <div class="trade__message trade__message--self">
                        <div class="trade__message-body">
                            <p class="trade__message-user trade__message-user--right">ユーザー名</p>
                            <div class="trade__message-text trade__message-text--self">
                                自分が送ったメッセージ
                            </div>
                            <div class="trade__message-actions">
                                <span class="trade__message-edit">編集</span>
                                <span class="trade__message-delete">削除</span>
                            </div>
                        </div>
                        <div class="trade__message-icon"></div>
                    </div>
                </div>

                <div class="trade__form">
                    <input class="trade__input" type="text" placeholder="取引メッセージを記入してください">
                    <button class="trade__image-button">画像を追加</button>
                    <button class="trade__send-button">▶</button>
                </div>
            </div>
        </div>
    </div>
@endsection