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
    // Meal Images
    Route::delete('meals/image/{id}', [MealController::class, 'deleteImage'])->name('meals.deleteImage');
    Route::get('/meals/export', [MealController::class, 'export'])->name('meals.export');
    Route::post('/meals/import', [MealController::class, 'import'])->name('meals.import');
    Route::resource('meals', MealController::class);
});

require __DIR__ . '/auth.php';


Route::get('/storage-link', function () {
    // Full path to your storage folder
    $target = '/home/u529110801/domains/testhapp.website/meal_calculator/storage/app/public';

    // Full path to the location where you want the symlink (public_html)
    $link = '/home/u529110801/domains/testhapp.website/public_html/storage';

    // Create the symlink
    symlink($target, $link);

    return 'Storage link has been created successfully';
});


Route::get('/check-path', function () {
    return base_path();
});
