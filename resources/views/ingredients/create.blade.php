@extends('layouts.master')

@section('title', 'Add Ingredient')

@section('breadcrumb_title', 'Create Ingredient')
@section('breadcrumb_route', 'Create Ingredient')


@section('content')
    <div class="card">


        <div class="card-header border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title"></h3>
                <div>
                    <a href="{{ route('ingredients.index') }}" class="btn btn-secondary btn-sm">< Back to Ingredients</a>
                </div>
            </div>
        </div>


        <div class="card-body">

            <form action="{{ route('ingredients.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Enter ingredient name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="unit" class="form-label">Unit</label>
                    <select name="unit" id="unit" class="form-select @error('unit') is-invalid @enderror" required>
                        <option value="" disabled {{ old('unit') ? '' : 'selected' }}>Select Unit</option>
                        <option value="gram" {{ old('unit') === 'gram' ? 'selected' : '' }}>Gram</option>
                        <option value="spoon" {{ old('unit') === 'spoon' ? 'selected' : '' }}>Spoon</option>
                        <option value="piece" {{ old('unit') === 'piece' ? 'selected' : '' }}>Piece</option>
                    </select>
                    @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price_per_unit" class="form-label">Price Per Unit</label>
                    <input type="number" step="0.01" min="0.01" name="price_per_unit" id="price_per_unit"
                        class="form-control @error('price_per_unit') is-invalid @enderror"
                        placeholder="Enter price per unit" value="{{ old('price_per_unit') }}" required>
                    @error('price_per_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Calorie Facts -->
                <div class="mb-3">
                    <label for="calories_per_unit" class="form-label">Calories Per Unit</label>
                    <input type="number" step="0.01" min="0" name="calories_per_unit" id="calories_per_unit"
                        class="form-control @error('calories_per_unit') is-invalid @enderror"
                        placeholder="Enter calories per unit" value="{{ old('calories_per_unit') }}" required>
                    @error('calories_per_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="protein_per_unit" class="form-label">Protein Per Unit</label>
                    <input type="number" step="0.01" min="0" name="protein_per_unit" id="protein_per_unit"
                        class="form-control @error('protein_per_unit') is-invalid @enderror"
                        placeholder="Enter protein per unit (g)" value="{{ old('protein_per_unit') }}" required>
                    @error('protein_per_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="carbs_per_unit" class="form-label">Carbohydrates Per Unit</label>
                    <input type="number" step="0.01" min="0" name="carbs_per_unit" id="carbs_per_unit"
                        class="form-control @error('carbs_per_unit') is-invalid @enderror"
                        placeholder="Enter carbs per unit (g)" value="{{ old('carbs_per_unit') }}" required>
                    @error('carbs_per_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="fats_per_unit" class="form-label">Fats Per Unit</label>
                    <input type="number" step="0.01" min="0" name="fats_per_unit" id="fats_per_unit"
                        class="form-control @error('fats_per_unit') is-invalid @enderror"
                        placeholder="Enter fats per unit (g)" value="{{ old('fats_per_unit') }}" required>
                    @error('fats_per_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="waste_percentage" class="form-label">Waste Percentage (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="waste_percentage"
                        id="waste_percentage" class="form-control @error('waste_percentage') is-invalid @enderror"
                        placeholder="Enter waste percentage" value="{{ old('waste_percentage') }}" required>
                    @error('waste_percentage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Add Ingredient</button>
                    <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
