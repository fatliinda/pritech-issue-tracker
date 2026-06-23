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
            <input
                type="text"
                id="issue-search"
                name="search"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="Title or description">
        </div>

        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">All</option>
                @foreach (App\Models\Issue::STATUSES as $status)
                <option value="{{ $status }}" @selected(request('status')===$status)>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">Priority</label>
            <select name="priority" class="form-select">
                <option value="">All</option>
                @foreach (App\Models\Issue::PRIORITIES as $priority)
                <option value="{{ $priority }}" @selected(request('priority')===$priority)>
                    {{ ucfirst($priority) }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Tag</label>
            <select name="tag" class="form-select">
                <option value="">All</option>
                @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" @selected((string) request('tag')===(string) $tag->id)>
                    {{ $tag->name }}
                </option>
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

        <tbody id="issues-table-body">
            @include('issues.partials.rows', ['issues' => $issues])
        </tbody>
    </table>

    <div id="issues-pagination" class="mt-3">
        {{ $issues->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('issue-search');
        const tableBody = document.getElementById('issues-table-body');
        const pagination = document.getElementById('issues-pagination');

        let searchTimeout = null;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                const query = searchInput.value;

                fetch(`{{ route('issues.search') }}?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        tableBody.innerHTML = html;

                        if (pagination) {
                            pagination.style.display = query.trim() ? 'none' : 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                    });
            }, 400);
        });
    });
</script>
@endsection