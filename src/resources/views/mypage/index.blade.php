@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css')}}">
@endsection

@section('content')
<div class="user-profile">
    <div class="user-profile__image">
        <img src="{{ asset('storage/users/' . $user->image_path) }}" alt="{{ $user->name }}">
    </div>
    <div class="user-profile__info">
        <div class="user-profile__name">{{ $user->name }}</div>
    </div>
    <div class="user-profile__actions">
        <a href="/mypage/profile" class="user-profile__edit-btn">プロフィールを編集</a>
    </div>
</div>

<div class="item-list">
    <div class="item-list__tab">
        <a href="/mypage?tab=sell" class="item-list__tab-link {{ request('tab', 'sell') === 'sell' ? 'item-list__tab-link--active' : '' }}">出品した商品</a>
        <a href="/mypage?tab=buy" class="item-list__tab-link {{ request('tab') === 'buy' ? 'item-list__tab-link--active' : '' }}">購入した商品</a>
    </div>

    <div class="item-list__grid">
        @foreach ($items as $item)
        <div class="item-card">
            <a href="{{ route('item.show', ['id' => $item->id]) }}">
                <div class="item-card__image">
                    <img src="{{ asset('storage/items/' . $item->image_path) }}" alt="{{ $item->name }}">
                </div>
            </a>
            <div class="item-card__name">{{ $item->name }}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection