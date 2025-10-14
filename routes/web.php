<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('Agent.Login');
});
Route::get('/Sign_up', [AgentController::class, 'signup'])->name('Agent.Register');
Route::post('/registration', [AgentController::class, 'register'])->name('agent.register');
Route::get('/reset_password', [AgentController::class, 'password'])->name('Agent.Password');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
