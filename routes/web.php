<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\SerchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;

Route::get('/', [PlaceController::class , 'index'])->name('home');

Route::get('/auto',[SerchController::class , 'auto'])->name('auto');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});




Route::get('/bookmark/{place}' , [BookmarkController::class , 'bookmark'])->name('bookmark');
Route::get('/bookmarks' , [BookmarkController::class , 'getByUser'])->name('bookmarks');

Route::resource('report', ReportController::class, ['only' => ['create','store']]);
Route::get('/serch' , [SerchController::class , 'show'])->name('serch.show');
Route::get('/{category:slug}' , [CategoryController::class , 'show'])->name('category.show');
Route::get('/place/create' , [PlaceController::class , 'create'])->name('place.create');
Route::get('/{place}/{slug}' , [PlaceController::class , 'show'])->name('place.show');
Route::post('/save' , [PlaceController::class , 'store'])->name('place.store');

Route::post('/heloworld' , [LikeController::class , 'store'])->name('like.store');
Route::post('/review' , [ReviewController::class , 'store'])->name('review.store');

