<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');


Route::controller(UserController::class)->prefix('users')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'index')->name('users');
    Route::get('/user', 'create')->name('create-user');
    Route::put('/user', 'store')->name('store-user');
    Route::get('/{user}', 'edit')->name('edit-user');
    Route::post('/{user}', 'update')->name('update-user');
    Route::delete('/{user}', 'destroy')->name('destroy-user');
});

require __DIR__ . '/auth.php';
