<?php

namespace App\Imports;

use App\Models\Meal;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class MealsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithEvents
{
    use SkipsFailures, SkipsErrors, RegistersEventListeners;

    /**
     * Map rows to models.
     */
    public function model(array $row)
    {
        return new Meal([
            'name' => $row['name'],
            'description' => $row['description'],
            'preparation_time' => $row['preparation_time'],
            'preparation_method' => $row['preparation_method'],
            'total_calories' => $row['total_calories'],
        ]);
    }

    /**
     * Validation rules for rows.
     */
    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:255',
            '*.description' => 'nullable|string',
            '*.preparation_time' => 'nullable|integer|min:0',
            '*.preparation_method' => 'nullable|string',
            '*.total_calories' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Handle failures during import.
     *
     * @param array $failures
     */
    public function onFailure(array $failures)
    {
        foreach ($failures as $failure) {
            logger()->error('Import failure', [
                'row' => $failure->row(), // Row number of failure
                'attribute' => $failure->attribute(), // Column name
                'errors' => $failure->errors(), // Validation errors
                'values' => $failure->values(), // The row data
            ]);
        }
    }
}
