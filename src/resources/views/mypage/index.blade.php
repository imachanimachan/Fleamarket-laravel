@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css')}}">
@endsection

@section('content')
<div class="user-profile">
    <div class="user-profile__image">
        <img src="{{ asset('storage/' . $user->image_path) }}" alt="{{ $user->name }}">
    </div>
    <div class="user-profile__info">
        <div class="user-profile__name">{{ $user->name }}</div>
    </div>
    <div class="user-profile__actions">
        <a href="" class="user-profile__edit-btn">プロフィールを編集</a>
    </div>
</div>

<div class="item-list">
    <div class="item-list__tab">
        <a href="" class="item-list__tab-link {{ request('tab') !== 'mylist' ? 'item-list__tab-link--active' : '' }}">出品した商品</a>
        <a href="" class="item-list__tab-link {{ request('tab') === 'mylist' ? 'item-list__tab-link--active' : '' }}">購入した商品</a>
    </div>

    <div class="item-list__grid">
        <div class="item-card">
            <a href="">
                <div class="item-card__image">
                    <img src="" alt="">
                </div>
            </a>
            <div class="item-card__name"></div>
        </div>
    </div>
</div>
@endsection