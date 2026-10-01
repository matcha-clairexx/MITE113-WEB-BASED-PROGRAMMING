<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
    </style>
</head>
<body>

<div class="container py-5" style="max-width: 1000px;">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Students</h2>
            <p class="text-muted mb-0">
                Logged in as {{ auth()->user()->name }}
                @if (auth()->user()->is_admin)
                    <span class="badge text-bg-dark ms-1">Admin</span>
                @endif
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('students.create') }}" class="btn btn-primary rounded-pill px-4">
                + Add New Student
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-secondary rounded-pill px-4">
                    Logout
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="list-group shadow-sm rounded-4 overflow-hidden">
        @forelse ($students as $student)
            <div class="list-group-item d-flex justify-content-between align-items-center p-4 bg-white gap-3">

                <div>
                    <h5 class="fw-semibold mb-1">{{ $student->name }}</h5>
                    <p class="mb-1 text-muted small">
                        {{ $student->email }} &nbsp;&bull;&nbsp;
                        {{ $student->program }} &nbsp;&bull;&nbsp;
                        Year {{ $student->year }} &nbsp;&bull;&nbsp;
                        ID: {{ $student->id_number }}
                    </p>
                    <span class="badge text-bg-light">
                        Owner: {{ $student->owner?->name ?? 'Unknown' }}
                    </span>
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-end">
                    <a href="{{ route('students.show', $student) }}"
                       class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        Show
                    </a>

                    @can('update', $student)
                        <a href="{{ route('students.edit', $student) }}"
                           class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            Edit
                        </a>
                    @endcan

                    @can('delete', $student)
                        <form action="{{ route('students.destroy', $student) }}" method="POST"
                              onsubmit="return confirm('Delete this student?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                Delete
                            </button>
                        </form>
                    @endcan
                </div>

            </div>
        @empty
            <div class="list-group-item p-5 text-center bg-white">
                <h5>No students found.</h5>
                <p class="text-muted mb-0">Create your first student record.</p>
            </div>
        @endforelse
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
