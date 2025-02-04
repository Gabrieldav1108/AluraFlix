<?php

use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VideosController;
use Illuminate\Support\Facades\Route;

Route::prefix('videos')
->name('videos.')
->group(function(){
    Route::get('/', [VideosController::class, 'list'])->name('list');
    Route::get('/search', [VideosController::class, 'search'])->name('search');
    Route::post('/', [VideosController::class, 'store'])->name('store');
    Route::put('/{video}', [VideosController::class, 'update'])->name('update');
    Route::delete('/{video}', [VideosController::class, 'destroy'])->name('destroy');
});

Route::prefix('categories')
->name('categories.')
->group(function(){
    Route::get('/', [CategoriesController::class, 'list'])->name('list');
    Route::get('/{id}', [CategoriesController::class, 'showOne'])->name('showOne');
    Route::get('/{id}/videos', [CategoriesController::class, 'videosByCategory'])->name('videosByCategory');
    Route::post('/', [CategoriesController::class, 'store'])->name('store');
    Route::put('/{id}', [CategoriesController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoriesController::class, 'delete'])->name('delete');
});

Route::prefix('login')
->name('login.')
->group(function(){
    Route::post('/', [UserController::class, 'store'])->name('store');
});