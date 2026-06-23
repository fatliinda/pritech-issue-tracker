@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Projects</h1>
    <a href="{{ route('projects.create') }}" class="btn btn-primary">Create Project</a>
</div>

<div class="page-card">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Start</th>
                <th>Deadline</th>
                <th>Issues</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
                <tr>
                    <td>
                        <a href="{{ route('projects.show', $project) }}" class="fw-semibold text-decoration-none">
                            {{ $project->name }}
                        </a>
                        <div class="text-muted small">{{ Str::limit($project->description, 80) }}</div>
                    </td>
                    <td>{{ $project->start_date?->format('Y-m-d') ?? '-' }}</td>
                    <td>{{ $project->deadline?->format('Y-m-d') ?? '-' }}</td>
                    <td>{{ $project->issues_count }}</td>
                    <td class="text-end">
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this project?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No projects found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $projects->links() }}
    </div>
</div>
@endsection
