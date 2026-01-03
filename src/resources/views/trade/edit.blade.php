@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/trade/edit.css') }}">
@endsection

@section('content')
    <div class="edit__container">
        <div class="edit__main">
            <h1>メッセージ編集</h1>
            <form action="{{ route('messages.update', $message->id) }}" method="POST">
                @csrf
                @method('PUT')
                <textarea name="body" id="body" cols="30" rows="10">{{ old('body', $message->body) }}</textarea>
                <button type="submit" class="submit">更新</button>
            </form>
        </div>
    </div>
@endsection
