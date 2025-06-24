<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Models\User;


    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (Request $request) {
        $user = User::findOrFail($request->route('id'));

        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, '署名が無効です。');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/mypage/profile');
    })->middleware(['signed'])->name('verification.verify');


    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '認証メールを再送しました。');
    })->middleware(['throttle:6,1'])->name('verification.send');


Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);
Route::get('/', [ItemController::class, 'index']);
Route::get ('/item/{id}', [ItemController::class, 'show'])->name('item.show');

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [ProfileController::class, 'index']);
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::patch('/mypage/profile', [ProfileController::class, 'update']);
    Route::post('/item/{id}/like', [ItemController::class, 'toggleLike'])->name('item.like');
    Route::post('/item/{id}/comment', [ItemController::class, 'comment'])->name('item.comment');
    Route::get('/purchase/item/{id}', [PurchaseController::class, 'purchase'])->name('item.purchase');
    Route::get('/purchase/address/{id}', [PurchaseController::class, 'index'])->name('address.purchase');
    Route::patch('/purchase/address/{id}', [PurchaseController::class, 'update'])->name('update.address');
    Route::post('/stripe/session/{id}', [StripeController::class, 'createSession'])->name('stripe.session');
    Route::get('/purchase/success', [StripeController::class, 'success'])->name('purchase.success');
    Route::get('/purchase/cancel', [StripeController::class, 'cancel'])->name('purchase.cancel');
    Route::get('/sell', [SellController::class, 'sell']);
    Route::post('/sell', [SellController::class, 'create']);
});