<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            [
                'name' => 'Tomato',
                'unit' => 'gram',
                'price_per_unit' => 0.5,
                'calories_per_unit' => 0.18,
                'protein_per_unit' => 0.01,
                'carbs_per_unit' => 0.04,
                'fats_per_unit' => 0.002,
            ],
            [
                'name' => 'Cheese',
                'unit' => 'gram',
                'price_per_unit' => 1.2,
                'calories_per_unit' => 4.02,
                'protein_per_unit' => 0.25,
                'carbs_per_unit' => 0.01,
                'fats_per_unit' => 0.33,
            ],
            [
                'name' => 'Flour',
                'unit' => 'gram',
                'price_per_unit' => 0.3,
                'calories_per_unit' => 3.64,
                'protein_per_unit' => 0.12,
                'carbs_per_unit' => 0.76,
                'fats_per_unit' => 0.01,
            ],
            [
                'name' => 'Salt',
                'unit' => 'spoon',
                'price_per_unit' => 0.1,
                'calories_per_unit' => 0.0,
                'protein_per_unit' => 0.0,
                'carbs_per_unit' => 0.0,
                'fats_per_unit' => 0.0,
            ],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::updateOrCreate(['name' => $ingredient['name']], $ingredient);
        }

        $this->command->info('Ingredients seeded successfully.');
    }
}
