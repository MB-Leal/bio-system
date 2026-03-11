<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnboardingController;

Route::get('/', function () {
    return view('welcome');
});
//rotas de cadastro
Route::get('/cadastro', [OnboardingController::class, 'index'])->name('onboarding.index');
Route::post('/cadastro', [OnboardingController::class, 'store'])->name('onboarding.store');
Route::view('/obrigado', 'onboarding-success')->name('onboarding.success');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
