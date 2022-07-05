<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Api\RegisterUserApi;
use App\Http\Api\LoginApi;
use App\Http\Api\SecondFactorApi;


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


Route::get('/', function () {
    return view('home');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/login-otp', function () {
    return view('auth.login-otp');
});
Route::get('/welcome', function () {
    return view('welcome');
});

Route::post('/api/register', [RegisterUserApi::class, 'register'])->name('api-register');
Route::post('/api/login', [LoginApi::class, 'login'])->name('api-login');
Route::post('/api/activateSecondFactor', [SecondFactorApi::class, 'activate'])->name('api-activateSecondFactor');
Route::post('/api/desactivateSecondFactor', [SecondFactorApi::class, 'desactivate'])->name('api-desactivateSecondFactor');
Route::post('/api/validateCode', [SecondFactorApi::class, 'validate'])->name('api-validateCode');
Route::get('/two-factor', [UserController::class, 'twoFactorAuth'])->name('two-factor');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
