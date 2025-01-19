<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'description',
        'preparation_time',
        'preparation_method',
        'servings',
        'total_calories',
    ];

    /**
     * Relationships
     */

    // A meal can have many ingredients
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredient')
            ->withPivot('quantity', 'total_cost', 'total_calories');
    }

    // A meal can include other meals (sub-meals)
    public function subMeals()
    {
        return $this->belongsToMany(Meal::class, 'meal_ingredient', 'meal_id', 'sub_meal_id')
            ->withPivot('quantity', 'total_cost', 'total_calories');
    }

    // A meal can have many images
    public function images()
    {
        return $this->hasMany(MealImage::class);
    }

    /**
     * Calculate the total cost of the meal.
     *
     * @return float
     */
    public function calculateTotalCost()
    {
        $totalCost = 0;

        // Calculate cost of direct ingredients
        foreach ($this->ingredients as $ingredient) {
            $quantity = $ingredient->pivot->quantity;
            $wasteFactor = 1 - (($ingredient->waste_percentage ?? 0) / 100);
            $totalCost += $ingredient->pivot->total_cost * $wasteFactor * $quantity;
        }

        // Calculate cost of sub-meals
        foreach ($this->subMeals as $subMeal) {
            $totalCost += $subMeal->pivot->total_cost;
        }

        return round($totalCost, 2);
    }


    /**
     * Calculate total calories.
     *
     * @return float
     */
    public function calculateCalorieFacts()
    {
        $totalCalories = 0;

        // Sum up calories from ingredients
        foreach ($this->ingredients as $ingredient) {
            $quantity = $ingredient->pivot->quantity;
            $totalCalories += $quantity * ($ingredient->calories_per_unit ?? 0);
        }

        // Include calories from sub-meals
        foreach ($this->subMeals as $subMeal) {
            $subMealQuantity = $subMeal->pivot->quantity;
            $totalCalories += $subMeal->calculateCalorieFacts() * $subMealQuantity;
        }

        return $totalCalories;
    }

    /**
     * Calculate total nutritional facts for the meal.
     *
     * @return array
     */
    public function calculateNutritionalFacts()
    {
        $nutritionalFacts = [
            'calories' => 0,
            'protein' => 0,
            'carbs' => 0,
            'fats' => 0,
        ];

        // Sum up nutrients from ingredients
        foreach ($this->ingredients as $ingredient) {
            $quantity = $ingredient->pivot->quantity;
            $wasteFactor = 1 - (($ingredient->waste_percentage ?? 0) / 100);
            $nutritionalFacts['calories'] += $quantity * ($ingredient->calories_per_unit ?? 0) * $wasteFactor;
            $nutritionalFacts['protein'] += $quantity * ($ingredient->protein_per_unit ?? 0) * $wasteFactor;
            $nutritionalFacts['carbs'] += $quantity * ($ingredient->carbs_per_unit ?? 0) * $wasteFactor;
            $nutritionalFacts['fats'] += $quantity * ($ingredient->fats_per_unit ?? 0) * $wasteFactor;
        }

        // Include nutrients from sub-meals
        foreach ($this->subMeals as $subMeal) {
            $subMealQuantity = $subMeal->pivot->quantity;
            $subFacts = $subMeal->calculateNutritionalFacts();

            $nutritionalFacts['calories'] += $subFacts['calories'] * $subMealQuantity;
            $nutritionalFacts['protein'] += $subFacts['protein'] * $subMealQuantity;
            $nutritionalFacts['carbs'] += $subFacts['carbs'] * $subMealQuantity;
            $nutritionalFacts['fats'] += $subFacts['fats'] * $subMealQuantity;
        }

        return $nutritionalFacts;
    }

}
