<?php

namespace App\Imports;

use App\Models\Meal;
use App\Models\Ingredient;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;

class MealsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsErrors
{
    use Importable, SkipsOnFailure, SkipsErrors;

    /**
     * Handle failures during import.
     *
     * @param Failure[] $failures
     */
    public function onFailure(...$failures)
    {
        foreach ($failures as $failure) {
            // Log the failure or handle it as needed
            logger()->error('Import failure', [
                'row' => $failure->row(), // Row number of failure
                'attribute' => $failure->attribute(), // Column name
                'errors' => $failure->errors(), // Validation errors
                'values' => $failure->values(), // The row data
            ]);
        }
    }

    /**
     * Map rows to models.
     *
     * @param array $row
     * @return Meal|null
     */
    public function model(array $row)
    {
        DB::transaction(function () use ($row) {
            $meal = Meal::updateOrCreate(
                ['name' => $row['meal_name']],
                [
                    'description' => $row['description'] ?? null,
                    'preparation_time' => $row['preparation_time'] ?? null,
                    'preparation_method' => $row['preparation_method'] ?? null,
                    'total_calories' => $row['total_calories'] ?? 0,
                ]
            );

            if (isset($row['ingredients'])) {
                $ingredients = explode(',', $row['ingredients']);
                foreach ($ingredients as $ingredientName) {
                    $ingredient = Ingredient::firstOrCreate(['name' => trim($ingredientName)]);
                    $meal->ingredients()->syncWithoutDetaching([
                        $ingredient->id => [
                            'quantity' => $row['ingredient_quantity'] ?? 0,
                            'total_cost' => $row['ingredient_cost'] ?? 0,
                            'total_calories' => $row['ingredient_calories'] ?? 0,
                        ],
                    ]);
                }
            }
        });
    }

    /**
     * Validation rules for the rows.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'meal_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'preparation_time' => 'nullable|integer|min:1',
            'preparation_method' => 'nullable|string',
            'total_calories' => 'nullable|numeric|min:0',
            'ingredients' => 'nullable|string',
            'ingredient_quantity' => 'nullable|numeric|min:0',
            'ingredient_cost' => 'nullable|numeric|min:0',
            'ingredient_calories' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function customValidationMessages(): array
    {
        return [
            'meal_name.required' => 'The meal name is required.',
            'preparation_time.integer' => 'The preparation time must be a valid number.',
            'total_calories.numeric' => 'The total calories must be a valid number.',
        ];
    }
}
