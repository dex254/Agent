<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
         Route::get('/signin', [AgentController::class, 'agentlogin'])->name('agent');
                Route::post('/signin', [AgentController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
        
});
Route::middleware('AGENT.auth')->group(function () {
     Route::get('/home', [AgentController::class, 'Dashboard'])->name('Agent.Dashboard');
     //logout post
     Route::post('/agent/logout', [AgentController::class, 'agentlogout'])->name('agent.logout');

     Route::get('/Programs_to_ai', [ProgramController::class, 'Program'])->name('Program.Add');
Route::post('/program', [ProgramController::class, 'postprogram'])->name('Program.Post');
 Route::get('/Whats_app', [WhatsAppController::class, 'WhatsApp'])->name('WhatsApp.Send');
 Route::post('/whatsapp/send', [WhatsAppController::class, 'sendMessage'])->name('whatsapp.send');
 //ai
   Route::get('/ai/chat', [AiChatController::class, 'index'])->name('AI.Chat');
    Route::post('/ai/ask', [AiChatController::class, 'ask'])->name('ai.ask');




});