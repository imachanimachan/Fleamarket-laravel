@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/confirm.css') }}">
@endsection

@section('content')
<div class="purchase-confirm">
    <div class="purchase-confirm__container">
        <div class="purchase-confirm__left">
            <div class="purchase-confirm__product">
                <div class="purchase-confirm__image">
                    <img src="{{ asset('storage/items/' . $item->image_path) }}" alt="{{ $item->name }}" class="purchase-confirm__image-img">
                </div>
                <div class="purchase-confirm__info">
                    <p class="purchase-confirm__name">{{ $item->name }}</p>
                    <p class="purchase-confirm__brand">{{ $item->brand }}</p>
                    <p class="purchase-confirm__price">￥ {{ $item->price }}</p>
                </div>
            </div>

            <hr class="purchase-confirm__divider">

            <div class="purchase-confirm__payment">
                <form action="{{ route('item.purchase', ['id' => $item->id]) }}" method="GET">
                    <label for="payment_method" class="purchase-confirm__payment-label">支払い方法</label>
                    <select id="payment_method" class="purchase-confirm__payment-select" name="payment_method" onchange="this.form.submit()">
                        <option>選択してください</option>
                        <option value="convenience" {{ request('payment_method') === 'convenience' ? 'selected' : ''  }}>コンビニ払い</option>
                        <option value="card" {{ request('payment_method') === 'card' ? 'selected' : '' }}>カード払い</option>
                    </select>
                    @if ($errors->has('payment_method'))
                    <p class="purchase-confirm__error">{{ $errors->first('payment_method') }}</p>
                    @endif
                </form>
            </div>
            <hr class="purchase-confirm__divider">

            <div class="purchase-confirm__section">
                <div class="purchase-confirm__label-area">
                    <p class="purchase-confirm__label">配送先</p>
                    <a href="{{ route('address.purchase', ['id' => $item->id, 'payment_method' => request('payment_method')]) }}" class="purchase-confirm__change-link">変更する</a>
                </div>
                @if($user)
                <p class="purchase-confirm__address">〒{{ $user->postcode }}<br>{{ $user->address }}<br>{{ $user->building }}</p>
                @else
                <p class="purchase-confirm__address">住所がまだ登録されていません</p>
                @endif
                @if ($errors->has('user_id'))
                <p class="purchase-confirm__error">{{ $errors->first('user_id') }}</p>
                @endif
            </div>

            <hr class="purchase-confirm__divider">

        </div>
        <div class="purchase-confirm__right">
            <div class="purchase-confirm__summary">
                <div class="purchase-confirm__row">
                    <span class="purchase-confirm__row-label">商品代金</span>
                    <span class="purchase-confirm__row-value">￥ {{ $item->price }}</span>
                </div>

                <div class="purchase-confirm__separator"></div>

                <div class="purchase-confirm__row">
                    <span class="purchase-confirm__row-label">支払い方法</span>
                    @if(request('payment_method') === 'card')
                    <span class="purchase-confirm__row-value">カード払い</span>
                    @elseif(request('payment_method') === 'convenience')
                    <span class="purchase-confirm__row-value">コンビニ払い</span>
                    @else
                    <span class="purchase-confirm__row-value">未選択</span>
                    @endif
                </div>
            </div>
            <form action="{{ route('stripe.session', ['id' => $item->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <input type="hidden" name="payment_method" value="{{ request('payment_method') }}">
                <button class="purchase-confirm__submit">購入する</button>
            </form>
        </div>
    </div>
</div>
@endsection