<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Chirper\ChirpController;
use App\Http\Controllers\Chirper\ProfileController;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;

Route::view('/', 'home')
    ->name('home');

// No need auth
Route::prefix('url_chirper')
    ->name('route_chirper.')
    ->group(function () {

        Route::get('/profile/{user}', [ProfileController::class, 'show'])
            ->name('route_profile.route_show');
});

// Need auth
Route::prefix('url_chirper')
    ->middleware('auth')
    ->name('route_chirper.')
    ->group(function () {

        Route::get('/', [ChirpController::class, 'index'])
            ->name('route_home');

        Route::post('/chirps', [ChirpController::class, 'store'])
            ->name('route_chirps.route_store');

        Route::get('/chirps/{url_chirp_id}/edit', [ChirpController::class, 'edit'])
            ->name('route_chirps.route_edit');

        Route::put('/chirps/{url_chirp_id}', [ChirpController::class, 'update'])
            ->name('route_chirps.route_update');

        Route::delete('/chirps/{url_chirp_id}', [ChirpController::class, 'destroy'])
            ->name('route_chirps.route_destroy');
});


Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');

Route::post('/register', Register::class)
    ->middleware('guest');

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', Login::class)
    ->middleware('guest');

Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');

Route::get('/profile/{user}', [ProfileController::class, 'show'])
    ->name('profile.show');