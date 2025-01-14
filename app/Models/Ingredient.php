<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'unit',
        'calories_per_unit',
        'protein_per_unit',
        'carbs_per_unit',
        'fats_per_unit',
        'price_per_unit',
    ];

    /**
     * Default attribute values.
     */
    protected $attributes = [
        'calories_per_unit' => 0.0,
        'protein_per_unit' => 0.0,
        'carbs_per_unit' => 0.0,
        'fats_per_unit' => 0.0,
        'price_per_unit' => 0.0,
    ];

    /**
     * Many-to-Many Relationship: An ingredient can belong to many meals.
     */
    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_ingredient')
            ->withPivot('quantity', 'total_cost', 'total_calories')
            ->withTimestamps();
    }

    /**
     * Calculate cost based on the given quantity.
     *
     * @param float $quantity
     * @return float
     * @throws \InvalidArgumentException
     */
    public function calculateCost(float $quantity): float
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Quantity must be greater than 0.');
        }

        return round($this->price_per_unit * $quantity, 2);
    }

    /**
     * Calculate total calories based on the given quantity.
     *
     * @param float $quantity
     * @return float
     * @throws \InvalidArgumentException
     */
    public function calculateCalories(float $quantity): float
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Quantity must be greater than 0.');
        }

        return round($this->calories_per_unit * $quantity, 2);
    }

    /**
     * Calculate total nutritional facts (calories, protein, carbs, fats) based on the given quantity.
     *
     * @param float $quantity
     * @return array
     */
    public function calculateNutrients(float $quantity): array
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Quantity must be greater than 0.');
        }

        return [
            'calories' => round($this->calories_per_unit * $quantity, 2),
            'protein' => round($this->protein_per_unit * $quantity, 2),
            'carbs' => round($this->carbs_per_unit * $quantity, 2),
            'fats' => round($this->fats_per_unit * $quantity, 2),
        ];
    }
}
