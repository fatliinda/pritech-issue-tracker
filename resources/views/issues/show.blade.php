@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h1 class="h3 mb-1">{{ $issue->title }}</h1>
        <p class="text-muted mb-0">
            Project:
            <a href="{{ route('projects.show', $issue->project) }}" class="text-decoration-none">
                {{ $issue->project->name }}
            </a>
        </p>
    </div>
    <div>
        <a href="{{ route('issues.edit', $issue) }}" class="btn btn-outline-primary">Edit</a>
        <a href="{{ route('issues.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="page-card mb-4">
    <p>{{ $issue->description }}</p>

    <div class="row">
        <div class="col-md-4"><strong>Status:</strong> {{ str_replace('_', ' ', $issue->status) }}</div>
        <div class="col-md-4"><strong>Priority:</strong> {{ $issue->priority }}</div>
        <div class="col-md-4"><strong>Due Date:</strong> {{ $issue->due_date?->format('Y-m-d') ?? '-' }}</div>
    </div>
</div>

<div class="page-card mb-4">
    <h2 class="h5 mb-3">Tags</h2>

    <div id="tag-list" class="mb-3">
        @foreach ($issue->tags as $tag)
            <span class="badge bg-dark badge-tag me-1 mb-1">
                {{ $tag->name }}
                <button type="button" class="btn-close btn-close-white btn-sm detach-tag" data-tag-id="{{ $tag->id }}" aria-label="Detach tag"></button>
            </span>
        @endforeach
    </div>

    <form id="attach-tag-form" class="row g-2 align-items-start">
        @csrf
        <div class="col-md-8">
            <select name="tag_id" id="tag-select" class="form-select">
                <option value="">Select tag</option>
                @foreach ($availableTags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <div class="text-danger small mt-1" id="tag-error"></div>
        </div>
        <div class="col-md-4 d-grid">
            <button class="btn btn-primary">Attach Tag</button>
        </div>
    </form>
</div>

<div class="page-card">
    <h2 class="h5 mb-3">Comments</h2>

    <form id="comment-form" class="mb-4">
        @csrf
        <div class="mb-2">
            <input type="text" name="author_name" class="form-control" placeholder="Your name">
            <div class="text-danger small mt-1" id="author_name-error"></div>
        </div>

        <div class="mb-2">
            <textarea name="body" rows="3" class="form-control" placeholder="Write a comment"></textarea>
            <div class="text-danger small mt-1" id="body-error"></div>
        </div>

        <button class="btn btn-success">Add Comment</button>
    </form>

    <div id="comments-list"></div>
    <div id="comments-pagination" class="mt-3"></div>
</div>
@endsection

@push('scripts')
<script>
const issueId = @json($issue->id);
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function escapeHtml(value) {
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function renderTags(tags, availableTags) {
    const tagList = document.getElementById('tag-list');
    const tagSelect = document.getElementById('tag-select');

    tagList.innerHTML = tags.length
        ? tags.map(tag => `
            <span class="badge bg-dark badge-tag me-1 mb-1">
                ${escapeHtml(tag.name)}
                <button type="button" class="btn-close btn-close-white btn-sm detach-tag" data-tag-id="${tag.id}" aria-label="Detach tag"></button>
            </span>
        `).join('')
        : '<span class="text-muted">No tags attached.</span>';

    tagSelect.innerHTML = '<option value="">Select tag</option>' + availableTags.map(tag => `
        <option value="${tag.id}">${escapeHtml(tag.name)}</option>
    `).join('');
}

async function loadComments(pageUrl = null) {
    const url = pageUrl ?? `/issues/${issueId}/comments`;

    const response = await fetch(url, {
        headers: {
            'Accept': 'application/json'
        }
    });

    const data = await response.json();

    document.getElementById('comments-list').innerHTML = data.html;
    document.getElementById('comments-pagination').innerHTML = data.pagination;
}

document.getElementById('comment-form').addEventListener('submit', async function (event) {
    event.preventDefault();

    document.getElementById('author_name-error').innerText = '';
    document.getElementById('body-error').innerText = '';

    const response = await fetch(`/issues/${issueId}/comments`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: new FormData(this)
    });

    const data = await response.json();

    if (!response.ok) {
        document.getElementById('author_name-error').innerText = data.errors?.author_name?.[0] ?? '';
        document.getElementById('body-error').innerText = data.errors?.body?.[0] ?? '';
        return;
    }

    document.getElementById('comments-list').insertAdjacentHTML('afterbegin', data.html);
    this.reset();
});

document.getElementById('attach-tag-form').addEventListener('submit', async function (event) {
    event.preventDefault();

    document.getElementById('tag-error').innerText = '';

    const response = await fetch(`/issues/${issueId}/tags`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: new FormData(this)
    });

    const data = await response.json();

    if (!response.ok) {
        document.getElementById('tag-error').innerText = data.errors?.tag_id?.[0] ?? 'Unable to attach tag.';
        return;
    }

    renderTags(data.tags, data.available_tags);
    this.reset();
});

document.addEventListener('click', async function (event) {
    const detachButton = event.target.closest('.detach-tag');

    if (!detachButton) {
        return;
    }

    const tagId = detachButton.dataset.tagId;

    const response = await fetch(`/issues/${issueId}/tags/${tagId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    });

    const data = await response.json();
    renderTags(data.tags, data.available_tags);
});

document.addEventListener('click', function (event) {
    const paginationLink = event.target.closest('#comments-pagination a');

    if (!paginationLink) {
        return;
    }

    event.preventDefault();
    loadComments(paginationLink.href);
});

loadComments();
</script>
@endpush
