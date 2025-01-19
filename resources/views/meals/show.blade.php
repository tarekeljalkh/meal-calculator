@extends('layouts.master')

@section('title', $meal->name)

@section('breadcrumb_title', 'Show Meal')
@section('breadcrumb_route', 'Show Meal')

@push('styles')
    <!-- Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-12">
                <div class="card">
                    <!-- Meal Title and Image -->
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title"></h3>
                            <div>
                                <a href="{{ route('meals.index') }}" class="btn btn-secondary btn-sm">
                                    < Back to Meals</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Meal Image -->
                            <div class="col-md-12 text-center">
                                @if ($meal->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $meal->images->first()->image_path) }}"
                                        class="img-fluid rounded" alt="Image of {{ $meal->name }}"
                                        style="max-height: 300px;"
                                        onerror="this.src='{{ asset('No_image_available.png') }}';">
                                @else
                                    <img src="{{ asset('No_image_available.png') }}" class="img-fluid rounded"
                                        alt="No image available" style="max-height: 200px;">
                                    <p class="text-muted">No image available.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Meal Details -->
                        <div class="row mt-4">
                            <!-- Left Column: Details -->
                            <div class="col-md-6">
                                <h4>Details</h4>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Prep Time</th>
                                            <td>{{ $meal->preparation_time ?? 'N/A' }} minutes</td>
                                        </tr>
                                        <tr>
                                            <th>Number of Servings</th>
                                            <td>{{ $meal->servings ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td>{{ $meal->description ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Calories</th>
                                            <td>{{ $meal->calculateNutritionalFacts()['calories'] ?? 'N/A' }} kcal</td>
                                        </tr>
                                        <tr>
                                            <th>Protein</th>
                                            <td>{{ $meal->calculateNutritionalFacts()['protein'] ?? 'N/A' }} g</td>
                                        </tr>
                                        <tr>
                                            <th>Carbs</th>
                                            <td>{{ $meal->calculateNutritionalFacts()['carbs'] ?? 'N/A' }} g</td>
                                        </tr>
                                        <tr>
                                            <th>Fats</th>
                                            <td>{{ $meal->calculateNutritionalFacts()['fats'] ?? 'N/A' }} g</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Right Column: Ingredients -->
                            <div class="col-md-6">
                                <h4>Ingredients</h4>
                                @if ($meal->ingredients->isNotEmpty())
                                    <ul class="list-group">
                                        @foreach ($meal->ingredients as $ingredient)
                                            <li class="list-group-item">
                                                {{ $ingredient->pivot->quantity }} {{ ucfirst($ingredient->unit) }} of
                                                <a
                                                    href="{{ route('ingredients.show', $ingredient->id) }}">{{ $ingredient->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">No ingredients listed for this meal.</p>
                                @endif

                                <!-- Sub-meals -->
                                @if ($meal->subMeals->isNotEmpty())
                                    <h5 class="mt-4">Sub-Meals</h5>
                                    <ul class="list-group">
                                        @foreach ($meal->subMeals as $subMeal)
                                            <li class="list-group-item">
                                                {{ $subMeal->pivot->quantity }} x
                                                <a href="{{ route('meals.show', $subMeal->id) }}">{{ $subMeal->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <!-- Preparation Method -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h4>Preparation Method</h4>
                                <p>{!! $meal->preparation_method ?? 'No preparation method provided.' !!}</p>
                            </div>
                        </div>

                        <!-- Gallery -->
                        @if ($meal->images->isNotEmpty())
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h4>Gallery</h4>
                                    <div class="row">
                                        @foreach ($meal->images as $image)
                                            <div class="col-md-3">
                                                <a href="{{ asset('storage/' . $image->image_path) }}"
                                                    data-lightbox="meal-gallery" data-title="{{ $meal->name }}">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                                        class="img-fluid rounded mb-2" alt="Image of {{ $meal->name }}"
                                                        onerror="this.src='{{ asset('No_image_available.png') }}';">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
@endpush
