<?php

use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $recipes = Recipe::where('user_id', Auth::id())->latest()->take(5)->get();
    $totalRecipes = Recipe::where('user_id', Auth::id())->count();

    return view('dashboard', compact('recipes', 'totalRecipes'));
})->middleware(['auth'])->name('dashboard');

// Bungkus route dengan middleware auth agar wajib login
Route::middleware('auth')->group(function () {
    // Route Generator Resep
    Route::get('/generator', [GeneratorController::class, 'index'])->name('generator.index');
    Route::post('/generator', [GeneratorController::class, 'generate'])->middleware('throttle:generator')->name('generator.generate');
    
    // Route CRUD Resep (Koleksi Resep)
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    
    // Route Profile (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Aktifkan kembali rute autentikasi bawaan Breeze
require __DIR__.'/auth.php';