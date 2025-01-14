<?php

namespace App\Exports;

use App\Models\Meal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MealsExport implements FromCollection, WithHeadings
{
    /**
     * Get the meals data to export.
     */
    public function collection()
    {
        return Meal::all([
            'name',
            'description',
            'preparation_time',
            'total_calories',
        ]);
    }

    /**
     * Specify the headings for the columns.
     */
    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Preparation Time (Minutes)',
            'Total Calories',
        ];
    }
}
