<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PRITECH Issue Tracker') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f6f8fb; }
        .page-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 24px; box-shadow: 0 10px 30px rgba(15, 23, 42, .04); }
        .badge-tag { display: inline-flex; align-items: center; gap: 6px; }
        .table td, .table th { vertical-align: middle; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('projects.index') }}">PRITECH Tracker</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('projects.index') }}">Projects</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('issues.index') }}">Issues</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tags.index') }}">Tags</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mb-5">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
