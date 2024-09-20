<?php

use App\Http\Controllers\SlackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('auth/slack',[SlackController::class,'redirectToSlack'])->name('slack.HomePage');
Route::get('auth/slack/callback',[SlackController::class,'handleSlackCallback'])->name('slack.redirect');
