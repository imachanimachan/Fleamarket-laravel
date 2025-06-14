<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/mypage/profile');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '認証メールを再送しました。');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

Route::post('/login', [LoginController::class, 'store']);
Route::get('/', [ItemController::class, 'index']);
Route::get ('/item/{id}', [ItemController::class, 'show'])->name('item.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [ProfileController::class, 'index']);
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::patch('/mypage/profile', [ProfileController::class, 'update']);
    Route::post('/item/{id}/like', [ItemController::class, 'toggleLike'])->name('item.like');
    Route::post('/item/{id}/comment', [ItemController::class, 'comment'])->name('item.comment');
    Route::get('/purchase/item/{id}', [PurchaseController::class, 'purchase'])->name('item.purchase');
    Route::get('/purchase/address/{id}', [PurchaseController::class, 'index'])->name('address.purchase');
    Route::patch('/purchase/address/{id}', [PurchaseController::class, 'update'])->name('update.address');
    Route::post('/purchase/item/{id}', [PurchaseController::class, 'create'])->name('item.order');
    Route::get('/sell', [SellController::class, 'sell']);
    Route::post('/sell', [SellController::class, 'create']);
});