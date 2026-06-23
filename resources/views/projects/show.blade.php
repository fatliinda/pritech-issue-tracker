@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h1 class="h3 mb-1">{{ $project->name }}</h1>
        <p class="text-muted mb-0">{{ $project->description }}</p>
    </div>
    <div>
        <a href="{{ route('projects.edit', $project) }}" class="btn btn-outline-primary">Edit</a>
        <a href="{{ route('issues.create', ['project_id' => $project->id]) }}" class="btn btn-primary">Add Issue</a>
    </div>
</div>

<div class="page-card mb-4">
    <div class="row">
        <div class="col-md-4"><strong>Start:</strong> {{ $project->start_date?->format('Y-m-d') ?? '-' }}</div>
        <div class="col-md-4"><strong>Deadline:</strong> {{ $project->deadline?->format('Y-m-d') ?? '-' }}</div>
        <div class="col-md-4"><strong>Issues:</strong> {{ $project->issues->count() }}</div>
    </div>
</div>

<div class="page-card">
    <h2 class="h5 mb-3">Project Issues</h2>

    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($project->issues as $issue)
                <tr>
                    <td><a href="{{ route('issues.show', $issue) }}" class="text-decoration-none fw-semibold">{{ $issue->title }}</a></td>
                    <td><span class="badge bg-info text-dark">{{ str_replace('_', ' ', $issue->status) }}</span></td>
                    <td><span class="badge bg-secondary">{{ $issue->priority }}</span></td>
                    <td>
                        @foreach ($issue->tags as $tag)
                            <span class="badge bg-dark">{{ $tag->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $issue->comments_count }}</td>
                    <td>{{ $issue->due_date?->format('Y-m-d') ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No issues for this project.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
