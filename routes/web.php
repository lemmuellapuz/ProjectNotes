<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegistrationController;
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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'signIn'])->name('login.attempt');

Route::get('/sign-up', [RegistrationController::class, 'index'])->name('signup');
Route::post('/sign-up', [RegistrationController::class, 'signUp'])->name('signup.attempt');