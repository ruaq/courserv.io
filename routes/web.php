<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::localized(function () {
    Route::middleware(\App\Http\Middleware\Localization::class)->group(function () {
        Route::view('/', 'welcome');

        Route::get('login', \App\Http\Livewire\Auth\Login::class)
            ->middleware('guest')
            ->name('login');

        Route::get('home', \App\Http\Livewire\Home::class)
            ->name('home');

        Route::get('teams', \App\Http\Livewire\Team::class)
            ->name('teams');

        Route::get('user', \App\Http\Livewire\User::class)
            ->name('user');

        Route::get('coursetype', \App\Http\Livewire\CourseType::class)
            ->name('coursetype');

        Route::get('course', \App\Http\Livewire\Course::class)
            ->name('course');

        Route::get('roles', \App\Http\Livewire\Role::class)
            ->name('roles');

        Route::get('password/reset/{hashedId}', \App\Http\Livewire\PasswordReset::class)
            ->middleware('signed')
            ->name('password.reset');
    });
});

Route::get('/email/verify', function () {
    return view('auth.verify-email'); // TODO correct message if still not confirmed email
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->to('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return redirect()->back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::fallback(\CodeZero\LocalizedRoutes\Controller\FallbackController::class)
    ->middleware(\CodeZero\LocalizedRoutes\Middleware\SetLocale::class);
