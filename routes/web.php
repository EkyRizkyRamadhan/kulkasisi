<?php
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Bungkus route dengan middleware auth agar wajib login
Route::middleware('auth')->group(function () {
    // Route Generator Resep
    Route::get('/generator', [GeneratorController::class, 'index'])->name('generator.index');
    Route::post('/generator', [GeneratorController::class, 'generate'])->name('generator.generate');
    
    // Route Profile (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';