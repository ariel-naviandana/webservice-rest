<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\CastsController;
use App\Http\Controllers\FilmsController;

Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::post('/users', [UsersController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');
Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');

Route::get('/reviews', [ReviewsController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewsController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{id}', [ReviewsController::class, 'show'])->name('reviews.show');
Route::put('/reviews/{id}', [ReviewsController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{id}', [ReviewsController::class, 'destroy'])->name('reviews.destroy');

Route::get('/genres', [GenresController::class, 'index'])->name('genres.index');
Route::post('/genres', [GenresController::class, 'store'])->name('genres.store');
Route::get('/genres/{id}', [GenresController::class, 'show'])->name('genres.show');
Route::put('/genres/{id}', [GenresController::class, 'update'])->name('genres.update');
Route::delete('/genres/{id}', [GenresController::class, 'destroy'])->name('genres.destroy');
Route::get('/genres/{id}/films', [GenresController::class, 'films'])->name('genres.films');

Route::get('/casts', [CastsController::class, 'index'])->name('casts.index');
Route::post('/casts', [CastsController::class, 'store'])->name('casts.store');
Route::get('/casts/{id}', [CastsController::class, 'show'])->name('casts.show');
Route::put('/casts/{id}', [CastsController::class, 'update'])->name('casts.update');
Route::delete('/casts/{id}', [CastsController::class, 'destroy'])->name('casts.destroy');
Route::get('/casts/{id}/films', [CastsController::class, 'films'])->name('casts.films');

Route::get('/films', [FilmsController::class, 'index'])->name('films.index');
Route::post('/films', [FilmsController::class, 'store'])->name('films.store');
Route::get('/films/{id}', [FilmsController::class, 'show'])->name('films.show');
Route::put('/films/{id}', [FilmsController::class, 'update'])->name('films.update');
Route::delete('/films/{id}', [FilmsController::class, 'destroy'])->name('films.destroy');

Route::post('/login', [UsersController::class, 'login'])->name('users.login');
