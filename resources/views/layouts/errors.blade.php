<div class="container-fluid">
    <!-- Global Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Global Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> There were some problems with your input:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Global Warnings (e.g., Import Failures) -->
    @if (session('failures'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Some rows were skipped:</strong>
            <ul class="mb-0">
                @foreach (session('failures') as $failure)
                    <li>Row {{ $failure->row() }}: {{ implode(', ', $failure->errors()) }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
