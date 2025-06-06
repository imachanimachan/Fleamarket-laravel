@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/index.css')}}">
@endsection

@section('content')
<div class="item-list">
    <div class="item-list__tab">
        <a href="/" class="item-list__tab-link {{ request('tab') !== 'mylist' ? 'item-list__tab-link--active' : '' }}">おすすめ</a>
        <a href="/?tab=mylist" class="item-list__tab-link {{ request('tab') === 'mylist' ? 'item-list__tab-link--active' : '' }}">マイリスト</a>
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