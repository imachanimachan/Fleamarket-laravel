@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="item-create">
    @if (session('message'))
    <div class="flash-message">
        {{ session('message') }}
    </div>
    @endif
    <h1 class="item-create__title">商品の出品</h1>
    <form action="/sell" method="POST" enctype="multipart/form-data" class="item-create__form">
        @csrf

        <div class="item-create__section">
            <label class="item-create__field-label">商品画像</label>
            @error('image_path')
            <p class="item__error">{{ $message }}</p>
            @enderror
            <div class="item-create__image-upload">
                <input type="file" name="image_path" class="item-create__image-input" id="image">
                <label for="image" class="item-create__image-label">画像を選択する</label>
            </div>
        </div>

        <div class="item-create__section">
            <h2 class="item-create__label">商品の詳細</h2>
            <hr class="item-create__divider">
            <label class="item-create__field-label">カテゴリー</label>
            @error('categories')
            <p class="item__error">{{ $message }}</p>
            @enderror
            <div class="item-create__category-list">
                @foreach($categories as $category)
                @php
                $checked = is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '';
                @endphp
                <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}" class="item-create__category-checkbox" {{ (old('categories') && in_array($category->id, old('categories'))) ? 'checked' : '' }}>
                <label for="category_{{ $category->id }}" class="item-create__category-button">{{ $category->name }}</label>
                @endforeach
            </div>

            <div class="item-create__field">
                <label for="condition" class="item-create__field-label">商品の状態</label>
                <select name="status_id" class="item-create__select">
                    <option value="" hidden>選択してください</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
                @error('status_id')
                <p class="item__error">{{ $message }}</p>
                @enderror
            </div>

            <h2 class="item-create__label">商品名と説明</h2>
            <hr class="item-create__divider">

            <div class="item-create__field">
                <label for="name" class="item-create__field-label">商品名</label>
                <input type="text" name="name" class="item-create__input" value="{{ old('name')}}">
                @error('name')
                <p class="item__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="item-create__field">
                <label for="brand" class="item-create__field-label">ブランド名</label>
                <input type="text" name="brand" class="item-create__input" value="{{ old('brand')}}">
            </div>

            <div class="item-create__field">
                <label for="description" class="item-create__field-label">商品の説明</label>
                <textarea name="description" class="item-create__textarea">{{ old('description')}}</textarea>
                @error('description')
                <p class="item__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="item-create__field">
                <label for="price" class="item-create__field-label">販売価格</label>
                <div class="item-create__price-input-wrap">
                    <span class="item-create__yen">￥</span>
                    <input type="text" name="price" class="item-create__input" value="{{ old('price')}}">
                </div>
                @error('price')
                <p class="item__error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="item-create__submit-wrap">
            <button type="submit" class="item-create__submit">出品する</button>
        </div>
    </form>
</div>
@endsection