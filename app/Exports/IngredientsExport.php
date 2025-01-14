<?php

namespace App\Exports;

use App\Models\Ingredient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IngredientsExport implements FromCollection, WithHeadings
{
    /**
     * Get the data to export.
     */
    public function collection()
    {
        return Ingredient::select(
            'name',
            'unit',
            'price_per_unit',
            'calories_per_unit',
            'protein_per_unit',
            'carbs_per_unit',
            'fats_per_unit',
            'waste_percentage'
        )->get();
    }

    /**
     * Define column headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'Name',
            'Unit',
            'Price Per Unit',
            'Calories Per Unit',
            'Protein Per Unit',
            'Carbs Per Unit',
            'Fats Per Unit',
            'Waste Percentage',
        ];
    }
}
