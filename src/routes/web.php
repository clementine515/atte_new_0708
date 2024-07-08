<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClockRecordController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Laravel\Fortify\Fortify;

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

Route::middleware('auth')->group(function (){
    Route::get('/', [ClockRecordController::class, 'index'])->name('home');
    Route::post('/checkin', [ClockRecordController::class, 'checkin'])->name('checkin');
    Route::post('/checkout', [ClockRecordController::class, 'checkout'])->name('checkout');
    Route::post('/break-start', [ClockRecordController::class, 'start']);
    Route::post('/break-end', [ClockRecordController::class, 'end']);
    Route::post('/attendance', [ClockRecordController::class, 'date_index'])->name('date_index');
    Route::get('/attendance', [ClockRecordController::class, 'date_index'])->name('date_index');
    Route::get('/user/{id}/records', [ClockRecordController::class, 'showRecords'])->name('user.rescords_each');

});

Fortify::verifyEmailView(function () {
    return view('auth.verify-email');
});

Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware(['auth'])
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register');
