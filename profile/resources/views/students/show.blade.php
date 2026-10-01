<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $student->name }} - Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5 d-flex justify-content-center">
    <div class="card border-0 shadow-sm rounded-4" style="max-width: 550px; width: 100%;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h3 class="fw-bold mb-1">{{ $student->name }}</h3>
                    <span class="badge text-bg-light">
                        Owner: {{ $student->owner?->name ?? 'Unknown' }}
                    </span>
                </div>
                @if ($student->owner_id === auth()->id())
                    <span class="badge text-bg-primary">Your record</span>
                @endif
            </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between px-0">
                    <span class="text-muted">Email</span>
                    <span class="fw-semibold">{{ $student->email }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0">
                    <span class="text-muted">Program</span>
                    <span class="fw-semibold">{{ $student->program }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0">
                    <span class="text-muted">Year</span>
                    <span class="fw-semibold">{{ $student->year }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0">
                    <span class="text-muted">Student ID</span>
                    <span class="fw-semibold">{{ $student->id_number }}</span>
                </li>
            </ul>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary flex-fill">
                    Back
                </a>

                @can('update', $student)
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-primary flex-fill">
                        Edit
                    </a>
                @endcan

                @can('delete', $student)
                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="flex-fill"
                          onsubmit="return confirm('Delete this student?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>

</body>
</html>
