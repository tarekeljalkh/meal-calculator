@extends('layouts.master')

@section('title', 'Create Meal')
@section('breadcrumb_title', 'Create Meal')
@section('breadcrumb_route', 'Create Meal')

@section('content')
<div class="card">

    <div class="card-header border-0">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title"></h3>
            <div>
                <a href="{{ route('meals.index') }}" class="btn btn-secondary btn-sm">< Back to Meals</a>
            </div>
        </div>
    </div>

    <div class="card-body">

        <form action="{{ route('meals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Meal name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Enter Description" required>{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="preparation_time" class="form-label">Preparation Time (minutes)</label>
                <input type="number" name="preparation_time" id="preparation_time" class="form-control" placeholder="Enter Preparation Time" value="{{ old('preparation_time') }}" required>
            </div>


            <div class="mb-3">
                <label for="preparation_method" class="form-label">Preparation Method</label>
                <textarea name="preparation_method" id="preparation_method" class="form-control" placeholder="Describe the Preparation Method">{{ old('preparation_method') }}</textarea>
            </div>

            <!-- Ingredients Section -->
            <div class="mb-3">
                <label class="form-label">Ingredients</label>
                <div id="ingredients-container">
                    <div class="d-flex mb-2 align-items-center ingredient-row">
                        <select name="ingredients[0][id]" class="form-select me-2" required>
                            <option value="">Select Ingredient</option>
                            @foreach($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }} ({{ ucfirst($ingredient->unit) }})</option>
                            @endforeach
                        </select>
                        <input type="number" step="0.01" name="ingredients[0][quantity]" class="form-control me-2" placeholder="Quantity" required>
                        <button type="button" class="btn btn-success btn-sm add-ingredient">+</button>
                    </div>
                </div>
            </div>

            <!-- Sub-Meals Section -->
            <div class="mb-3">
                <label class="form-label">Sub-Meals</label>
                <div id="sub-meals-container">
                    <div class="d-flex mb-2 align-items-center sub-meal-row">
                        <select name="sub_meals[0][id]" class="form-select me-2">
                            <option value="">Select Sub-Meal</option>
                            @foreach($meals as $meal)
                                <option value="{{ $meal->id }}">{{ $meal->name }}</option>
                            @endforeach
                        </select>
                        <input type="number" step="0.01" name="sub_meals[0][quantity]" class="form-control me-2" placeholder="Quantity">
                        <button type="button" class="btn btn-success btn-sm add-sub-meal">+</button>
                    </div>
                </div>
            </div>

            <!-- Images Section -->
            <div class="mb-3">
                <label class="form-label">Upload Images</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Add Meal</button>
                <a href="{{ route('meals.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#preparation_method'))
        .catch(error => {
            console.error(error);
        });
</script>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        let ingredientIndex = 1;
        let subMealIndex = 1;

        document.querySelector('.add-ingredient').addEventListener('click', function () {
            const container = document.getElementById('ingredients-container');
            const row = document.querySelector('.ingredient-row').cloneNode(true);
            row.querySelector('select').setAttribute('name', `ingredients[${ingredientIndex}][id]`);
            row.querySelector('input').setAttribute('name', `ingredients[${ingredientIndex}][quantity]`);
            row.querySelector('.add-ingredient').remove();
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm remove-row';
            removeButton.textContent = '-';
            row.appendChild(removeButton);
            container.appendChild(row);
            ingredientIndex++;
        });

        document.querySelector('.add-sub-meal').addEventListener('click', function () {
            const container = document.getElementById('sub-meals-container');
            const row = document.querySelector('.sub-meal-row').cloneNode(true);
            row.querySelector('select').setAttribute('name', `sub_meals[${subMealIndex}][id]`);
            row.querySelector('input').setAttribute('name', `sub_meals[${subMealIndex}][quantity]`);
            row.querySelector('.add-sub-meal').remove();
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm remove-row';
            removeButton.textContent = '-';
            row.appendChild(removeButton);
            container.appendChild(row);
            subMealIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-row')) {
                e.target.closest('.d-flex').remove();
            }
        });
    });
</script>

@endpush
