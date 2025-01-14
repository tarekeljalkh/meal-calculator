<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MealController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ingredients
    Route::get('/ingredients/export', [IngredientController::class, 'export'])->name('ingredients.export');
    Route::post('/ingredients/import', [IngredientController::class, 'import'])->name('ingredients.import');
    Route::resource('ingredients', IngredientController::class);

    // Meals
    Route::get('/meals/export', [MealController::class, 'export'])->name('meals.export');
    Route::post('/meals/import', [MealController::class, 'import'])->name('meals.import');
    Route::resource('meals', MealController::class);

    // Meal Images
    Route::delete('meals/image/{id}', [MealController::class, 'deleteImage'])->name('meals.deleteImage');
});

require __DIR__ . '/auth.php';
