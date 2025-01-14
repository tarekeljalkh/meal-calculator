<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Ingredient;
use App\Models\MealImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meals = Meal::with('ingredients', 'subMeals')->get(); // Eager load relationships
        return view('meals.index', compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ingredients = Ingredient::all();
        $meals = Meal::all(); // Pass existing meals for sub-meals
        return view('meals.create', compact('ingredients', 'meals'));
    }

    public function show(Meal $meal)
{
    // Eager load relationships to avoid N+1 queries
    $meal->load('ingredients', 'subMeals', 'images');

    // Return the show view with the meal data
    return view('meals.show', compact('meal'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'preparation_time' => 'nullable|numeric|min:1',
            'preparation_method' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
            'ingredients' => 'nullable|array',
            'ingredients.*.id' => 'exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.01',
            'sub_meals' => 'nullable|array',
            'sub_meals.*.id' => 'exists:meals,id',
            'sub_meals.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $meal = Meal::create($request->only(['name', 'description', 'preparation_time', 'preparation_method']));

        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $ingredient) {
                $meal->ingredients()->attach($ingredient['id'], [
                    'quantity' => $ingredient['quantity'],
                    'total_cost' => Ingredient::find($ingredient['id'])->price_per_unit * $ingredient['quantity'],
                    'total_calories' => Ingredient::find($ingredient['id'])->calculateCalories($ingredient['quantity']),
                ]);
            }
        }

        if ($request->has('sub_meals')) {
            foreach ($request->sub_meals as $subMeal) {
                $meal->subMeals()->attach($subMeal['id'], [
                    'quantity' => $subMeal['quantity'],
                    'total_cost' => Meal::find($subMeal['id'])->calculateTotalCost() * $subMeal['quantity'],
                    'total_calories' => Meal::find($subMeal['id'])->calculateCalorieFacts() * $subMeal['quantity'],
                ]);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('meal_images', 'public');
                MealImage::create(['meal_id' => $meal->id, 'image_path' => $path]);
            }
        }

        return redirect()->route('meals.index')->with('success', 'Meal created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        $ingredients = Ingredient::all();
        $meals = Meal::all()->except($meal->id);
        $meal->load('ingredients', 'subMeals', 'images');
        return view('meals.edit', compact('meal', 'ingredients', 'meals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'preparation_time' => 'nullable|numeric|min:1',
            'preparation_method' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
            'ingredients' => 'nullable|array',
            'ingredients.*.id' => 'exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.01',
            'sub_meals' => 'nullable|array',
            'sub_meals.*.id' => 'exists:meals,id',
            'sub_meals.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $meal->update($request->only(['name', 'description', 'preparation_time', 'preparation_method']));

        $ingredients = [];
        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $ingredient) {
                $ingredients[$ingredient['id']] = [
                    'quantity' => $ingredient['quantity'],
                    'total_cost' => Ingredient::find($ingredient['id'])->price_per_unit * $ingredient['quantity'],
                    'total_calories' => Ingredient::find($ingredient['id'])->calculateCalories($ingredient['quantity']),
                ];
            }
        }
        $meal->ingredients()->sync($ingredients);

        $subMeals = [];
        if ($request->has('sub_meals')) {
            foreach ($request->sub_meals as $subMeal) {
                $subMeals[$subMeal['id']] = [
                    'quantity' => $subMeal['quantity'],
                    'total_cost' => Meal::find($subMeal['id'])->calculateTotalCost() * $subMeal['quantity'],
                    'total_calories' => Meal::find($subMeal['id'])->calculateCalorieFacts() * $subMeal['quantity'],
                ];
            }
        }
        $meal->subMeals()->sync($subMeals);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('meal_images', 'public');
                MealImage::create(['meal_id' => $meal->id, 'image_path' => $path]);
            }
        }

        return redirect()->route('meals.index')->with('success', 'Meal updated successfully.');
    }

    /**
     * Remove a specific image associated with the meal.
     */
    public function deleteImage($imageId)
    {
        $image = MealImage::findOrFail($imageId);

        // Delete the image file from storage
        Storage::disk('public')->delete($image->image_path);

        // Remove the record from the database
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Remove the specified meal from storage.
     */
    public function destroy(Meal $meal)
    {
        // Delete associated images
        foreach ($meal->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $meal->delete();

        return redirect()->route('meals.index')->with('success', 'Meal deleted successfully.');
    }

}
