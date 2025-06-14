@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/edit.css')}}">
@endsection

@section('content')
<div class="edit">
    <h2 class="edit__title">住所の変更</h2>
    <form class="edit__form" method="POST" action="{{ route('update.address', ['id' => $item->id, 'payment_method' => request('payment_method')]) }}">
        @method('PATCH')
        @csrf
        <label class="edit__label">郵便番号
            <input type="text" name="postcode" class="edit__input" value="{{ old('postcode') }}">
            @error('postcode')
            <p class="edit__error">{{ $message }}</p>
            @enderror
        </label>
        <label class="edit__label">住所
            <input type="text" name="address" class="edit__input" value="{{ old('address') }}">
            @error('address')
            <p class="edit__error">{{ $message }}</p>
            @enderror
        </label>
        <label class="edit__label">建物名
            <input type="text" name="building" class="edit__input" value="{{ old('building') }}">
            @error('building')
            <p class="edit__error">{{ $message }}</p>
            @enderror
        </label>
        <button class="edit__button" type="submit">更新する</button>
    </form>
</div>
@endsection