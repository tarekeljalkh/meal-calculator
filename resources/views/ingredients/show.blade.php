@extends('layouts.master')

@section('title', 'Ingredient Details')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Ingredient Details</h3>
        <a href="{{ route('ingredients.index') }}" class="btn btn-secondary btn-sm">Back to Ingredients</a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <h5><strong>Name:</strong></h5>
                <p>{{ $ingredient->name }}</p>
            </div>
            <div class="col-md-6">
                <h5><strong>Unit:</strong></h5>
                <p>{{ ucfirst($ingredient->unit) }}</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <h5><strong>Price Per Unit:</strong></h5>
                <p>${{ number_format($ingredient->price_per_unit, 2) }}</p>
            </div>
            <div class="col-md-6">
                <h5><strong>Calories Per Unit:</strong></h5>
                <p>{{ number_format($ingredient->calories_per_unit, 2) }} kcal</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h5><strong>Protein Per Unit:</strong></h5>
                <p>{{ number_format($ingredient->protein_per_unit, 2) }} g</p>
            </div>
            <div class="col-md-4">
                <h5><strong>Carbohydrates Per Unit:</strong></h5>
                <p>{{ number_format($ingredient->carbs_per_unit, 2) }} g</p>
            </div>
            <div class="col-md-4">
                <h5><strong>Fats Per Unit:</strong></h5>
                <p>{{ number_format($ingredient->fats_per_unit, 2) }} g</p>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="btn btn-warning">Edit Ingredient</a>
            <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this ingredient?')">
                    Delete Ingredient
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
