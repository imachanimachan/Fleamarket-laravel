<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;

Route::get('/', [ItemController::class, 'index']);
Route::get('/mypage', [ProfileController::class, 'index']);
Route::get('/mypage/profile', [ProfileController::class, 'edit']);
Route::patch('/mypage/profile', [ProfileController::class, 'update']);
Route::get ('/item/{id}', [ItemController::class, 'show'])->name('item.show');
Route::post('/item/{id}/like', [ItemController::class, 'toggleLike'])->name('item.like');
Route::post('/item/{id}/comment', [ItemController::class, 'comment'])->name('item.comment');
Route::post('/purchase/item/{id}',[PurchaseController::class, 'purchase'])->name('item.purchase');