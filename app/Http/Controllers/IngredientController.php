<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Imports\IngredientsImport;
use App\Exports\IngredientsExport;
use Maatwebsite\Excel\Facades\Excel;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredients.index', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ingredients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|in:gram,spoon,piece',
            'price_per_unit' => 'required|numeric|min:0',
            'calories_per_unit' => 'nullable|numeric|min:0',
            'protein_per_unit' => 'nullable|numeric|min:0',
            'carbs_per_unit' => 'nullable|numeric|min:0',
            'fats_per_unit' => 'nullable|numeric|min:0',
            'waste_percentage' => 'nullable|numeric|min:0|max:100', // Validate waste percentage
        ]);

        Ingredient::create($request->all());

        return redirect()->route('ingredients.index')->with('success', 'Ingredient created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient)
    {
        return view('ingredients.show', compact('ingredient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|in:gram,spoon,piece',
            'price_per_unit' => 'required|numeric|min:0',
            'calories_per_unit' => 'nullable|numeric|min:0',
            'protein_per_unit' => 'nullable|numeric|min:0',
            'carbs_per_unit' => 'nullable|numeric|min:0',
            'fats_per_unit' => 'nullable|numeric|min:0',
            'waste_percentage' => 'nullable|numeric|min:0|max:100', // Validate waste percentage
        ]);

        $ingredient->update($request->all());

        return redirect()->route('ingredients.index')->with('success', 'Ingredient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return redirect()->route('ingredients.index')->with('success', 'Ingredient deleted successfully.');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        try {
            $import = new IngredientsImport();
            Excel::import($import, $file);

            // Check for failures
            if ($import->failures()->isNotEmpty()) {
                return redirect()->back()->with('error', 'Some rows could not be imported. Please check the file.');
            }

            return redirect()->back()->with('success', 'Ingredients imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function export()
    {
        return Excel::download(new IngredientsExport, 'ingredients.xlsx');
    }
}
