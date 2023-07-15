<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/v1/users')->group(function(){
	Route::controller(UserController::class)->group(function(){
		// Get all user data
		Route::get('/', 'allUser');
		// Get user data by id
		Route::get('/show/{id}', 'findUserId');
		// Store user data without profile_picture
		Route::post('/store', 'storeUserNoPicture');
		// Update user data without profile_picture
		Route::put('/update/{id}', 'updateUserNoPicture');
		// Update picture profile user by id
		Route::put('/picture-update/{id}', 'updatePictureProfile');
		// Update password user by id
		Route::put('/password-update/{id}', 'updatePasswordUser');
		// Update status user by id
		Route::patch('/status-update/{id}', 'updateStatusUser');
		// Delete user data by id
		Route::delete('/delete/{id}', 'deleteUserById');
	});
	Route::controller(AuthController::class)->group(function(){
		// Store loin data
		Route::post('/login', 'loginUser');
		// Store register data
		Route::post('/register', 'registerUser');
		// Forgot password user
		Route::post('/forgot-password', 'forgotPassword');
	});
});

Route::prefix('/v2')->group(function(){
	Route::controller(UserController::class)->group(function(){
		// Store user data with profile_picture
		Route::post('/users', [UserController::class, 'storeUserWithPicture']);
	});
});