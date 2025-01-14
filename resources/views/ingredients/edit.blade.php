@extends('layouts.master')

@section('title', 'Edit Ingredient')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Edit Ingredient</h3>
        <a href="{{ route('ingredients.index') }}" class="btn btn-secondary btn-sm">Back to Ingredients</a>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('ingredients.update', $ingredient->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $ingredient->name) }}"
                    placeholder="Enter ingredient name"
                    required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="unit" class="form-label">Unit</label>
                <select
                    name="unit"
                    id="unit"
                    class="form-select @error('unit') is-invalid @enderror"
                    required>
                    <option value="gram" {{ old('unit', $ingredient->unit) == 'gram' ? 'selected' : '' }}>Gram</option>
                    <option value="spoon" {{ old('unit', $ingredient->unit) == 'spoon' ? 'selected' : '' }}>Spoon</option>
                    <option value="piece" {{ old('unit', $ingredient->unit) == 'piece' ? 'selected' : '' }}>Piece</option>
                </select>
                @error('unit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price_per_unit" class="form-label">Price Per Unit</label>
                <input
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="price_per_unit"
                    id="price_per_unit"
                    class="form-control @error('price_per_unit') is-invalid @enderror"
                    value="{{ old('price_per_unit', $ingredient->price_per_unit) }}"
                    placeholder="Enter price per unit"
                    required>
                @error('price_per_unit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Calorie Facts -->
            <div class="mb-3">
                <label for="calories_per_unit" class="form-label">Calories Per Unit</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="calories_per_unit"
                    id="calories_per_unit"
                    class="form-control @error('calories_per_unit') is-invalid @enderror"
                    value="{{ old('calories_per_unit', $ingredient->calories_per_unit) }}"
                    placeholder="Enter calories per unit"
                    required>
                @error('calories_per_unit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="protein_per_unit" class="form-label">Protein Per Unit</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="protein_per_unit"
                    id="protein_per_unit"
                    class="form-control @error('protein_per_unit') is-invalid @enderror"
                    value="{{ old('protein_per_unit', $ingredient->protein_per_unit) }}"
                    placeholder="Enter protein per unit (g)"
                    required>
                @error('protein_per_unit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="carbs_per_unit" class="form-label">Carbohydrates Per Unit</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="carbs_per_unit"
                    id="carbs_per_unit"
                    class="form-control @error('carbs_per_unit') is-invalid @enderror"
                    value="{{ old('carbs_per_unit', $ingredient->carbs_per_unit) }}"
                    placeholder="Enter carbs per unit (g)"
                    required>
                @error('carbs_per_unit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="fats_per_unit" class="form-label">Fats Per Unit</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="fats_per_unit"
                    id="fats_per_unit"
                    class="form-control @error('fats_per_unit') is-invalid @enderror"
                    value="{{ old('fats_per_unit', $ingredient->fats_per_unit) }}"
                    placeholder="Enter fats per unit (g)"
                    required>
                @error('fats_per_unit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Update Ingredient</button>
                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
