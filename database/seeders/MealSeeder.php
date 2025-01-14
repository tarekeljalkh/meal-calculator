<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\MealImage;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // Retrieve Ingredients
            $tomato = Ingredient::firstOrCreate(['name' => 'Tomato'], ['unit' => 'gram', 'price_per_unit' => 0.5]);
            $salt = Ingredient::firstOrCreate(['name' => 'Salt'], ['unit' => 'spoon', 'price_per_unit' => 0.1]);
            $cheese = Ingredient::firstOrCreate(['name' => 'Cheese'], ['unit' => 'gram', 'price_per_unit' => 1.2]);
            $flour = Ingredient::firstOrCreate(['name' => 'Flour'], ['unit' => 'gram', 'price_per_unit' => 0.3]);

            // Create Meals
            $tomatoPaste = Meal::create([
                'name' => 'Tomato Paste',
                'description' => 'A paste made from fresh tomatoes.',
                'preparation_time' => 30,
                'preparation_method' => 'Chop tomatoes and cook with salt.',
            ]);

            $pizza = Meal::create([
                'name' => 'Pizza',
                'description' => 'A delicious pizza with cheese and tomato paste.',
                'preparation_time' => 90,
                'preparation_method' => 'Prepare dough, spread tomato paste, and add toppings.',
            ]);

            // Attach Ingredients to Tomato Paste
            $tomatoPaste->ingredients()->attach($tomato->id, [
                'quantity' => 500,
                'total_cost' => $tomato->calculateCost(500),
                'total_calories' => $tomato->calculateCalories(500),
            ]);

            $tomatoPaste->ingredients()->attach($salt->id, [
                'quantity' => 2,
                'total_cost' => $salt->calculateCost(2),
                'total_calories' => $salt->calculateCalories(2),
            ]);

            // Attach Ingredients and Sub-meals to Pizza
            $pizza->subMeals()->attach($tomatoPaste->id, [
                'quantity' => 1,
                'total_cost' => $tomatoPaste->calculateTotalCost(),
                'total_calories' => $tomatoPaste->calculateCalorieFacts(),
            ]);

            $pizza->ingredients()->attach($cheese->id, [
                'quantity' => 200,
                'total_cost' => $cheese->calculateCost(200),
                'total_calories' => $cheese->calculateCalories(200),
            ]);

            $pizza->ingredients()->attach($flour->id, [
                'quantity' => 300,
                'total_cost' => $flour->calculateCost(300),
                'total_calories' => $flour->calculateCalories(300),
            ]);

            // Calculate and Update Total Calories for Meals
            $tomatoPaste->load('ingredients', 'subMeals');
            $tomatoPaste->update(['total_calories' => $tomatoPaste->calculateCalorieFacts()]);

            $pizza->load('ingredients', 'subMeals');
            $pizza->update(['total_calories' => $pizza->calculateCalorieFacts()]);

            // Attach Images
            MealImage::create(['meal_id' => $tomatoPaste->id, 'image_path' => 'images/tomato_paste1.jpg']);
            MealImage::create(['meal_id' => $tomatoPaste->id, 'image_path' => 'images/tomato_paste2.jpg']);
            MealImage::create(['meal_id' => $pizza->id, 'image_path' => 'images/pizza1.jpg']);
            MealImage::create(['meal_id' => $pizza->id, 'image_path' => 'images/pizza2.jpg']);

            $this->command->info('Meal seeding completed successfully.');
        } catch (\Exception $e) {
            $this->command->error("Error seeding meals: {$e->getMessage()}");
        }
    }
}
