<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\LogoutController;
use App\Http\Controllers\Authentication\RegistrationController;
use App\Http\Controllers\Notes\NotesController;
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

Route::middleware('auth')->group(function(){

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('notes/list', [NotesController::class, 'table'])->name('notes.table');
    Route::post('notes/search-qr', [NotesController::class, 'searchQr'])->name('notes.search.via-qr');
    Route::resource('/notes', NotesController::class);
    
});



