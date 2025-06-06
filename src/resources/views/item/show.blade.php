@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/show.css') }}">
@endsection

@section('content')
<div class="item-detail">
    <div class="item-detail__container">
        <div class="item-detail__image-box">
            <img src="{{ asset('storage/items/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-detail__image">
        </div>
        <div class="item-detail__info-box">
            <h1 class="item-detail__name">{{ $item->name }}</h1>
            <p class="item-detail__brand">{{ $item->brand_name }}</p>
            <p class="item-detail__price">¥{{ number_format($item->price) }} <span class="item-detail__tax">(税込)</span></p>

            <div class="item-detail__actions">
                <form method="POST" action="{{ route('item.like', ['id' => $item->id]) }}" class="item-detail__icon">
                    @csrf
                    <button type="submit" class="item-detail__icon-mark {{ $liked ? 'item-detail__icon-mark--active' : '' }}">
                        ☆
                    </button>
                    <span class="item-detail__icon-count">{{ $item->likes_count }}</span>
                </form>
                <div class="item-detail__icon">
                    <span class="item-detail__icon-mark">💬</span>
                    <span class="item-detail__icon-count">{{ $item->comments_count }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('item.purchase', ['id' => $item->id]) }}" class="item-detail__form">
                @csrf
                <button type="submit" class="item-detail__purchase-btn">購入手続きへ</button>
            </form>

            {{-- 商品説明 --}}
            <div class="item-detail__description">
                {{ $item->description }}
            </div>

            <div class="item-detail__section">
                <h2 class="item-detail__section-title">商品の情報</h2>
                <p class="item-detail__text">カテゴリー：
                    @foreach($item->categories as $category)
                    <span class="item-detail__category">{{ $category->name }}</span>
                    @endforeach
                </p>
                <p class="item-detail__text">商品の状態：{{ $item->status->name }}</p>
            </div>

            <div class="item-detail__section">
                <h2 class="item-detail__section-title">コメント（{{ $item->comments_count }}）</h2>
                @foreach ($item->comments as $comment)
                <div class="item-detail__comment">
                    <div class="item-detail__comment-user">{{ $comment->user->name }}</div>
                    <p class="item-detail__comment-text">{{ $comment->comment }}</p>
                </div>
                @endforeach

                {{-- コメント投稿フォーム --}}
                <form action="{{ route('item.comment', ['id' => $item->id]) }}" method="POST" class="item-detail__comment-form">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <p class="item-detail__form-title">商品へのコメント</p> <textarea name="comment" class="item-detail__textarea"></textarea>
                    <button type="submit" class="item-detail__submit-btn">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection