@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/index.css')}}">
@endsection

@section('content')
<div class="item-list">
    <div class="item-list__tab">
        <a href="{{ url('/') }}?tab=recommend&keyword={{ $keyword }}" class="item-list__tab-link {{ $tab === 'recommend' ? 'item-list__tab-link--active' : '' }}">おすすめです</a>
        <a href="{{ url('/') }}?tab=mylist&keyword={{ $keyword }}" class="item-list__tab-link {{ $tab === 'mylist' ? 'item-list__tab-link--active' : '' }}">マイリスト</a>
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
            @if($item->is_sold)
            <span class="item-card__sold">Sold</span>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection