<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function(){
	Route::get('/', 'login')->name('auth.login');
	Route::get('/register', 'register')->name('auth.register');
	Route::get('/lupa-password', 'lupaPassword')->name('auth.lupaPassword');
});
Route::middleware('CheckCookie')->group(function(){
	Route::controller(UserController::class)->group(function(){
		Route::prefix('/crud')->group(function(){
			Route::get('/', 'index')->name('crud.dashboard');
			Route::get('/profile', 'profil')->name('crud.profil');
		});
	});
});