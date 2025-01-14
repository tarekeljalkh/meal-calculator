@extends('layouts.master')

@section('title', 'Meal Calculator | Ingredients')

@push('styles')
@endpush

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Ingredients</h3>
                            <a href="{{ route('ingredients.create') }}" class="btn btn-primary">Add Ingredient</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                @if($ingredients->isEmpty())
                                    <div class="alert alert-info">No ingredients found. Add some ingredients to get started!</div>
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
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ingredients as $ingredient)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $ingredient->name }}</td>
                                                    <td>{{ ucfirst($ingredient->unit) }}</td>
                                                    <td>${{ number_format($ingredient->price_per_unit, 2) }}</td>
                                                    <td>{{ number_format($ingredient->calories_per_unit, 2) }} kcal</td>
                                                    <td>{{ number_format($ingredient->protein_per_unit, 2) }} g</td>
                                                    <td>{{ number_format($ingredient->carbs_per_unit, 2) }} g</td>
                                                    <td>{{ number_format($ingredient->fats_per_unit, 2) }} g</td>
                                                    <td>
                                                        <a href="{{ route('ingredients.show', $ingredient->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this ingredient?')">
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

@endsection
