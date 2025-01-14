@extends('layouts.master')

@section('title', 'Edit Meal')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Edit Meal</h3>
            <a href="{{ route('meals.index') }}" class="btn btn-secondary btn-sm">Back to Meals</a>
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

            <form action="{{ route('meals.update', $meal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Meal name"
                        value="{{ old('name', $meal->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Enter Description" required>{{ old('description', $meal->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="preparation_time" class="form-label">Preparation Time (minutes)</label>
                    <input type="number" name="preparation_time" id="preparation_time" class="form-control"
                        placeholder="Enter Preparation Time" value="{{ old('preparation_time', $meal->preparation_time) }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="preparation_method" class="form-label">Preparation Method</label>
                    <textarea name="preparation_method" id="preparation_method" class="form-control"
                        placeholder="Describe the Preparation Method">{{ old('preparation_method', $meal->preparation_method) }}</textarea>
                </div>

                <!-- Ingredients Section -->
                <div class="mb-3">
                    <label class="form-label">Ingredients</label>
                    <div id="ingredients-container">
                        @foreach ($meal->ingredients as $index => $ingredient)
                            <div class="d-flex mb-2 align-items-center">
                                <select name="ingredients[{{ $index }}][id]" class="form-select me-2" required>
                                    <option value="">Select Ingredient</option>
                                    @foreach ($ingredients as $ing)
                                        <option value="{{ $ing->id }}"
                                            {{ $ing->id == $ingredient->id ? 'selected' : '' }}>
                                            {{ $ing->name }} ({{ ucfirst($ing->unit) }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" step="0.01" name="ingredients[{{ $index }}][quantity]"
                                    class="form-control me-2" placeholder="Quantity"
                                    value="{{ old('ingredients.' . $index . '.quantity', $ingredient->pivot->quantity) }}"
                                    required>
                                <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success btn-sm add-ingredient">Add Ingredient</button>
                </div>

                <!-- Sub-Meals Section -->
                <div class="mb-3">
                    <label class="form-label">Sub-Meals</label>
                    <div id="sub-meals-container">
                        @foreach ($meal->subMeals as $index => $subMeal)
                            <div class="d-flex mb-2 align-items-center">
                                <select name="sub_meals[{{ $index }}][id]" class="form-select me-2">
                                    <option value="">Select Sub-Meal</option>
                                    @foreach ($meals as $m)
                                        <option value="{{ $m->id }}"
                                            {{ $m->id == $subMeal->id ? 'selected' : '' }}>
                                            {{ $m->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" step="0.01" name="sub_meals[{{ $index }}][quantity]"
                                    class="form-control me-2" placeholder="Quantity"
                                    value="{{ old('sub_meals.' . $index . '.quantity', $subMeal->pivot->quantity) }}">
                                <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success btn-sm add-sub-meal">Add Sub-Meal</button>
                </div>

                <!-- Images Section -->
                <div class="mb-3">
                    <label class="form-label">Current Images</label>
                    <div class="mb-2">
                        @foreach ($meal->images as $image)
                            <div class="d-flex align-items-center mb-2">
                                <!-- Display Current Image -->
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Meal Image"
                                    style="width: 100px; height: auto; margin-right: 10px;">

                                <!-- Form to Delete Image -->
                                <form action="{{ route('meals.deleteImage', $image->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <!-- Input to Add New Images -->
                    <label class="form-label">Add New Images</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                </div>


                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Meal</button>
                    <a href="{{ route('meals.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

@endsection


@push('scripts')
    <!-- JavaScript for Dynamic Rows -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let ingredientIndex = {{ $meal->ingredients->count() }};
            let subMealIndex = {{ $meal->subMeals->count() }};

            document.querySelector('.add-ingredient').addEventListener('click', function() {
                const container = document.getElementById('ingredients-container');
                const newRow = `
                <div class="d-flex mb-2 align-items-center">
                    <select name="ingredients[${ingredientIndex}][id]" class="form-select me-2" required>
                        <option value="">Select Ingredient</option>
                        @foreach ($ingredients as $ing)
                            <option value="{{ $ing->id }}">{{ $ing->name }} ({{ ucfirst($ing->unit) }})</option>
                        @endforeach
                    </select>
                    <input type="number" step="0.01" name="ingredients[${ingredientIndex}][quantity]" class="form-control me-2" placeholder="Quantity" required>
                    <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                </div>`;
                container.insertAdjacentHTML('beforeend', newRow);
                ingredientIndex++;
            });

            document.querySelector('.add-sub-meal').addEventListener('click', function() {
                const container = document.getElementById('sub-meals-container');
                const newRow = `
                <div class="d-flex mb-2 align-items-center">
                    <select name="sub_meals[${subMealIndex}][id]" class="form-select me-2">
                        <option value="">Select Sub-Meal</option>
                        @foreach ($meals as $m)
                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" step="0.01" name="sub_meals[${subMealIndex}][quantity]" class="form-control me-2" placeholder="Quantity">
                    <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                </div>`;
                container.insertAdjacentHTML('beforeend', newRow);
                subMealIndex++;
            });

            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-row')) {
                    e.target.closest('.d-flex').remove();
                }
            });
        });
    </script>
@endpush
