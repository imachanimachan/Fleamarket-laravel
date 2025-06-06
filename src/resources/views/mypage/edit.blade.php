@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/edit.css')}}">
@endsection

@section('content')
<div class="edit">
    <h2 class="edit__title">プロフィール設定</h2>
    <form class="edit__form" method="POST" action="/mypage/profile" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="edit__image-box">
            <div class="edit__image-circle">
                <img src="{{ Auth::user()->image_path ? asset('storage/' . Auth::user()->image_path) : '' }}" alt="" class="edit__image-preview">
            </div>
            <label class="edit__image-label">画像を選択する
                <input type="file" name="image_path" class="edit__image-input">
            </label>
        </div>
        <label class="edit__label">ユーザー名
            <input type="text" name="name" value="{{ old('name') }}" class="edit__input">
        </label>
        <label class="edit__label">郵便番号
            <input type="text" name="postcode" value="{{ old('postcode') }}" class="edit__input">
        </label>
        <label class="edit__label">住所
            <input type="text" name="address" value="{{ old('address') }}" class="edit__input">
        </label>
        <label class="edit__label">建物名
            <input type="text" name="building" value="{{ old('building') }}" class="edit__input">
        </label>
        <button class="edit__button" type="submit">更新する</button>
    </form>
</div>
@endsection