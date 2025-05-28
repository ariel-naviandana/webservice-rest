<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\CastsController;
use App\Http\Controllers\FilmsController;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckTokenExpiry;
use App\Http\Middleware\ReviewOwnerOrAdmin;

// Public Routes
Route::post('/register', [AuthController::class, 'register'])->name('auth.register')->middleware('throttle:5,1');;
Route::post('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('throttle:5,1');

// Public Read-Only Routes
Route::get('/films', [FilmsController::class, 'index'])->name('films.index');
Route::get('/films/{id}', [FilmsController::class, 'show'])->name('films.show');
Route::get('/genres', [GenresController::class, 'index'])->name('genres.index');
Route::get('/genres/{id}', [GenresController::class, 'show'])->name('genres.show');
Route::get('/genres/{id}/films', [GenresController::class, 'films'])->name('genres.films');
Route::get('/casts', [CastsController::class, 'index'])->name('casts.index');
Route::get('/casts/{id}', [CastsController::class, 'show'])->name('casts.show');
Route::get('/casts/{id}/films', [CastsController::class, 'films'])->name('casts.films');

// Authenticated Routes
Route::middleware(['auth:sanctum', CheckTokenExpiry::class])->group(function () {
    Route::get('/reviews', [ReviewsController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{id}', [ReviewsController::class, 'show'])->name('reviews.show');
    Route::post('/reviews', [ReviewsController::class, 'store'])->name('reviews.store');

    Route::middleware([ReviewOwnerOrAdmin::class])->group(function () {
        Route::put('/reviews/{id}', [ReviewsController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{id}', [ReviewsController::class, 'destroy'])->name('reviews.destroy');
    });

    Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Admin-Only Routes
    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::put('/users/{id}/role', [AuthController::class, 'assignRole'])->name('users.assignRole');

        Route::post('/films', [FilmsController::class, 'store'])->name('films.store');
        Route::put('/films/{id}', [FilmsController::class, 'update'])->name('films.update');
        Route::delete('/films/{id}', [FilmsController::class, 'destroy'])->name('films.destroy');
        Route::put('/films/{id}/add-cast/{castId}', [FilmsController::class, 'addCast'])->name('films.addCast');
        Route::put('/films/{id}/add-genre/{genreId}', [FilmsController::class, 'addGenre'])->name('films.addGenre');

        Route::post('/genres', [GenresController::class, 'store'])->name('genres.store');
        Route::put('/genres/{id}', [GenresController::class, 'update'])->name('genres.update');
        Route::delete('/genres/{id}', [GenresController::class, 'destroy'])->name('genres.destroy');

        Route::post('/casts', [CastsController::class, 'store'])->name('casts.store');
        Route::put('/casts/{id}', [CastsController::class, 'update'])->name('casts.update');
        Route::delete('/casts/{id}', [CastsController::class, 'destroy'])->name('casts.destroy');
    });
});
