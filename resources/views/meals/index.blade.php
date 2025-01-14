@extends('layouts.master')

@section('title', 'Meal Calculator | Meals')

@section('breadcrumb_title', 'Meals')
@section('breadcrumb_route', 'Meals')

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
                                    <!-- Add Meal Button -->
                                    <a href="{{ route('meals.create') }}" class="btn btn-primary">Add Meal</a>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">

                                            <!-- Import Meals -->
                                            <li>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#importMealsModal">
                                                    <i class="fas fa-upload me-2"></i> Import Meals
                                                </button>
                                            </li>

                                            <!-- Export to Excel -->
                                            <li>
                                                <a href="{{ route('meals.export') }}" class="dropdown-item">
                                                    <i class="fas fa-file-export me-2"></i> Export to Excel
                                                </a>
                                            </li>

                                            <!-- Download Template -->
                                            <li>
                                                <a href="{{ asset('templates/meals_import_template.xlsx') }}"
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
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Total Calories</th>
                                            <th>Total Cost</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($meals as $meal)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $meal->name }}</td>
                                                <td>{{ $meal->description }}</td>
                                                <td>{{ number_format($meal->calculateCalorieFacts(), 2) }} kcal</td>
                                                <td>${{ number_format($meal->calculateTotalCost(), 2) }}</td>
                                                <td>
                                                    <a href="{{ route('meals.show', $meal->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('meals.edit', $meal->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('meals.destroy', $meal->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this meal?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

    <!-- Import Meals Modal -->
    <div class="modal fade" id="importMealsModal" tabindex="-1" aria-labelledby="importMealsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importMealsModalLabel">Import Meals</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('meals.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Select Excel File</label>
                            <input type="file" name="file" id="file"
                                class="form-control @error('file') is-invalid @enderror" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
