@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/trade/index.css') }}">
@endsection

@section('content')
    <div class="trade">
        <div class="trade__container">
            <div class="trade__sidebar">
                <p class="trade__sidebar-title">その他の取引</p>
                <ul class="trade__item-list">
                    @foreach ($tradeItems as $tradeItem)
                        <li class="trade__item">
                            <form action="{{ route('trade.index', ['id' => $tradeItem->id]) }}" method="GET"
                                onclick="this.querySelector('input[name=draft]').value = document.querySelector('.trade__input').value">

                                {{-- 下書き本文 --}}
                                <input type="hidden" name="draft">

                                {{-- どの商品から移動したか --}}
                                <input type="hidden" name="from_item_id" value="{{ $currentItem->id }}">
                                <button type="submit"
                                    class="trade__item-link
                            {{ $tradeItem->id === $currentItem->id ? 'trade__item-link--active' : '' }}">
                                    {{ $tradeItem->name }}
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="trade__main">
                <div class="trade__header">
                    <div class="trade__user">
                        <div class="trade__user-icon"><img
                                src="{{ $tradeUser->image_path ? asset('storage/users/' . $tradeUser->image_path) : asset('images/default.png') }}"
                                alt="{{ $tradeUser->name }}">
                        </div>
                        <p class="trade__user-name">「{{ $tradeUser->name }}」さんとの取引画面</p>
                    </div>
                    @php
                        $order = $currentItem->order;
                        $isBuyer = Auth::id() === $order->user_id;
                        $isSeller = Auth::id() === $currentItem->user_id;
                    @endphp

                    @if (($isBuyer && !$order->buyer_completed) || ($isSeller && $order->buyer_completed && !$order->seller_completed))
                        <form method="POST" action="{{ route('trade.complete', ['item' => $currentItem->id]) }}">
                            @csrf
                            <button type="submit" class="trade__complete-button">
                                取引を完了する
                            </button>
                        </form>
                    @endif

                </div>

                <div class="trade__product">
                    <div class="item-card__image"><img src="{{ asset('storage/items/' . $currentItem->image_path) }}"
                            alt="{{ $currentItem->name }}"></div>
                    <div class="trade__product-info">
                        <p class="trade__product-name">{{ $currentItem->name }}</p>
                        <p class="trade__product-price">{{ $currentItem->price }}</p>
                    </div>
                </div>

                <div class="trade__chat">
                    @if ($messages->isEmpty())
                        <p class="trade__no-message">まだメッセージはありません</p>
                    @else
                        @foreach ($messages as $message)
                            @php
                                $isMe = $message->user_id === Auth::id();
                            @endphp

                            <div class="trade__message {{ $isMe ? 'trade__message--self' : 'trade__message--other' }}">
                                @if (!$isMe)
                                    <!-- 相手のメッセージ：左側にアイコン -->
                                    <div class="trade__user-icon">
                                        <img src="{{ $message->user->image_path
                                            ? asset('storage/users/' . $message->user->image_path)
                                            : asset('images/default.png') }}"
                                            alt="{{ $message->user->name }}">
                                    </div>
                                @endif

                                <div class="trade__message-body">
                                    <p class="trade__message-user">{{ $message->user->name }}</p>
                                    <p class="trade__message-text">{{ $message->body }}</p>
                                    @if ($message->image_path)
                                        <div class="trade__message-image">
                                            <img src="{{ asset('storage/' . $message->image_path) }}" alt="メッセージ画像">
                                        </div>
                                    @endif
                                </div>

                                @if ($isMe)
                                    <div class="trade__user-icon">
                                        <img src="{{ $message->user->image_path
                                            ? asset('storage/users/' . $message->user->image_path)
                                            : asset('images/default.png') }}"
                                            alt="{{ $message->user->name }}">
                                    </div>
                                @endif
                            </div>
                            @if ($isMe)
                                <div class="trade__message-actions">
                                    <form action="{{ route('messages.destroy', $message) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="trade__message-delete">
                                            削除
                                        </button>
                                    </form>
                                    <div class="trade__message-actions">
                                        <a href="{{ route('messages.edit', $message) }}" class="trade__message-edit">
                                            編集
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <form class="trade__form" action="{{ route('trade.message.store', ['id' => $currentItem->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if ($errors->has('body'))
                <p class="chat__error">
                    {{ $errors->first('body') }}
                </p>
            @endif
            <input class="trade__input" type="text" name="body" value="{{ old('body', $draftBody ?? '') }}"
                placeholder="取引メッセージを記入してください">
            @if ($errors->has('image'))
                <p class="chat__error">
                    {{ $errors->first('image') }}
                </p>
            @endif

            <input type="file" name="image" accept="image/*" hidden id="trade-image-input">

            <label for="trade-image-input" class="trade__image-button">
                画像を追加
            </label>

            <button class="trade__send-button" type="submit">▶</button>
        </form>
        @if (session('showReviewModal'))
            <div class="review-modal">
                <div class="review-modal__content">
                    <h2>取引の評価</h2>

                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $currentItem->id }}">
                        <input type="hidden" name="reviewed_user_id" value="{{ $tradeUser->id }}">

                        <div class="review-modal__stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <label>
                                    <input type="radio" name="rating" value="{{ $i }}" required>
                                    ★
                                </label>
                            @endfor
                        </div>

                        <button type="submit">評価を送信</button>
                    </form>
                </div>
            </div>
        @endif

    </div>
    </div>
    </div>
@endsection
