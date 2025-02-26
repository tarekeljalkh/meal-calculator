@extends('layouts.master')

@section('title', 'Meal Calculator | Ingredients')

@section('breadcrumb_title', 'Ingredients')
@section('breadcrumb_route', 'Ingredients')


@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title"></h3>
                                <div>
                                    <!-- Add Ingredient Button -->
                                    <a href="{{ route('ingredients.create') }}" class="btn btn-primary">Add Ingredient</a>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">

                                            <!-- Import Ingredients -->
                                            <li>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#importModal">
                                                    <i class="fas fa-upload me-2"></i> Import Ingredients
                                                </button>
                                            </li>

                                            <!-- Export to Excel -->
                                            <li>
                                                <a href="{{ route('ingredients.export') }}" class="dropdown-item">
                                                    <i class="fas fa-file-export me-2"></i> Export to Excel
                                                </a>
                                            </li>

                                            <!-- Download Template -->
                                            <li>
                                                <a href="{{ asset('templates/ingredients_import_template.xlsx') }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-download me-2"></i> Download Template
                                                </a>
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                @if ($ingredients->isEmpty())
                                    <div class="alert alert-info">No ingredients found. Add some ingredients to get started!
                                    </div>
                                @else
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Unit</th>
                                                <th>Price Per Unit</th>
                                                <th>Calories</th>
                                                <th>Protein</th>
                                                <th>Carbs</th>
                                                <th>Fats</th>
                                                <th>Waste Percentage</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ingredients as $ingredient)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $ingredient->name }}</td>
                                                    <td>{{ ucfirst($ingredient->unit) }}</td>
                                                    <td>${{ number_format($ingredient->price_per_unit, 2) }}</td>
                                                    <td>{{ number_format($ingredient->calories_per_unit, 2) }} kcal</td>
                                                    <td>{{ number_format($ingredient->protein_per_unit, 2) }} g</td>
                                                    <td>{{ number_format($ingredient->carbs_per_unit, 2) }} g</td>
                                                    <td>{{ number_format($ingredient->fats_per_unit, 2) }} g</td>
                                                    <td>{{ number_format($ingredient->waste_percentage, 2) }}%</td>
                                                    <td>
                                                        <a href="{{ route('ingredients.show', $ingredient->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('ingredients.edit', $ingredient->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('ingredients.destroy', $ingredient->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this ingredient?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Ingredients</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ingredients.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Select Excel File</label>
                            <input type="file" name="file" id="file"
                                class="form-control @error('file') is-invalid @enderror" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
