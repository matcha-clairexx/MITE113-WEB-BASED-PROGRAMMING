<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProfileController::class, 'index']);
Route::get('/profiles', [ProfileController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
| Only users who are NOT logged in can access these routes.
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
| Only logged-in users can logout.
*/

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('students.index');
    })->name('dashboard');

    Route::resource('students', StudentController::class);
});
