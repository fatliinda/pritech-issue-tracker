@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Issues</h1>
    <a href="{{ route('issues.create') }}" class="btn btn-primary">Create Issue</a>
</div>

<div class="page-card mb-4">
    <form method="GET" action="{{ route('issues.index') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Title or description">
        </div>

        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">All</option>
                @foreach (App\Models\Issue::STATUSES as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">Priority</label>
            <select name="priority" class="form-select">
                <option value="">All</option>
                @foreach (App\Models\Issue::PRIORITIES as $priority)
                    <option value="{{ $priority }}" @selected(request('priority') === $priority)>{{ ucfirst($priority) }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Tag</label>
            <select name="tag" class="form-select">
                <option value="">All</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @selected((string) request('tag') === (string) $tag->id)>{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 d-grid">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>
</div>

<div class="page-card">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Title</th>
                <th>Project</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Tags</th>
                <th>Comments</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($issues as $issue)
                <tr>
                    <td><a href="{{ route('issues.show', $issue) }}" class="fw-semibold text-decoration-none">{{ $issue->title }}</a></td>
                    <td><a href="{{ route('projects.show', $issue->project) }}" class="text-decoration-none">{{ $issue->project->name }}</a></td>
                    <td><span class="badge bg-info text-dark">{{ str_replace('_', ' ', $issue->status) }}</span></td>
                    <td><span class="badge bg-secondary">{{ $issue->priority }}</span></td>
                    <td>
                        @foreach ($issue->tags as $tag)
                            <span class="badge bg-dark">{{ $tag->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $issue->comments_count }}</td>
                    <td class="text-end">
                        <a href="{{ route('issues.edit', $issue) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('issues.destroy', $issue) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this issue?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No issues found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $issues->links() }}
    </div>
</div>
@endsection
