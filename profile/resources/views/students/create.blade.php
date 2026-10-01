<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
    </style>
</head>
<body>
<div class="d-flex justify-content-center align-items-center py-5" style="min-height: 100vh;">
    <form action="{{ route('students.store') }}" method="POST"
          class="p-4 shadow-sm rounded bg-white" style="max-width: 500px; width: 100%;">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">Add New Student</h3>
            <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="program" class="form-label">Program</label>
            <input type="text" name="program" id="program" class="form-control"
                   value="{{ old('program') }}" required>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" name="year" id="year" min="1" max="5"
                   class="form-control" value="{{ old('year') }}" required>
        </div>

        <div class="mb-4">
            <label for="id_number" class="form-label">ID Number</label>
            <input type="text" name="id_number" id="id_number" class="form-control"
                   value="{{ old('id_number') }}" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Student</button>
    </form>
</div>
</body>
</html>
