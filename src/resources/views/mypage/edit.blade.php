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
                <img src="{{ Auth::user()->image_path ? asset('storage/users/' . Auth::user()->image_path) : '' }}" alt="" class="edit__image-preview">
            </div>
            <label class="edit__image-label">画像を選択する
                <input type="file" name="image_path" class="edit__image-input">
            </label>
        </div>
        @error('image_path')
        <p class="edit__error">{{ $message }}</p>
        @enderror
        <label class="edit__label">ユーザー名
            <input type="text" name="name" value="{{ $user->name }}" class="edit__input" value="{{ old('name') }}">
        </label>
        <label class="edit__label">郵便番号
            <input type="text" name="postcode" value="{{ $user->postcode }}" class="edit__input" value="{{ old('postcode') }}">
        </label>
        <label class="edit__label">住所
            <input type="text" name="address" value="{{ $user->address }}" class="edit__input" value="{{ old('address') }}">
        </label>
        <label class="edit__label">建物名
            <input type="text" name="building" value="{{ $user->building }}" class="edit__input" value="{{ old('building') }}">
        </label>
        <button class="edit__button" type="submit">更新する</button>
    </form>
</div>
@endsection