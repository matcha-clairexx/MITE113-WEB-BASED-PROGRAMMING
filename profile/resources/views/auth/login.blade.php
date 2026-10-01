<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; min-height: 100vh; }
        .login-card { max-width: 430px; width: 100%; }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card border-0 shadow-sm rounded-4 login-card">
        <div class="card-body p-4 p-md-5">
            <h2 class="fw-bold text-center mb-2">Student Manager</h2>
            <p class="text-muted text-center mb-4">Sign in to continue</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill">
                    Login
                </button>
                <br>
                <p>
                    <b>Username:</b> test@example.com <br>
                    <b>Password:</b> password
                    <br>
                    <br>
                    <b>Username:</b> second@example.com <br>
                    <b>Password:</b> password
                    <br>
                    <br>
                    <b>Username:</b> admin@example.com <br>
                    <b>Password:</b> password
                </p>
            </form>
        </div>


    </div>
</div>
</body>
</html>
