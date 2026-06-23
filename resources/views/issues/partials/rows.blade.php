@forelse ($issues as $issue)
<tr>
    <td>
        <a href="{{ route('issues.show', $issue) }}" class="fw-semibold text-decoration-none">
            {{ $issue->title }}
        </a>
    </td>

    <td>
        <a href="{{ route('projects.show', $issue->project) }}" class="text-decoration-none">
            {{ $issue->project->name }}
        </a>
    </td>

    <td>
        <span class="badge bg-info text-dark">
            {{ str_replace('_', ' ', $issue->status) }}
        </span>
    </td>

    <td>
        <span class="badge bg-secondary">
            {{ $issue->priority }}
        </span>
    </td>

    <td>
        @foreach ($issue->tags as $tag)
        <span class="badge bg-dark">{{ $tag->name }}</span>
        @endforeach
    </td>

    <td>{{ $issue->comments_count }}</td>

    <td class="text-end">
        <a href="{{ route('issues.edit', $issue) }}" class="btn btn-sm btn-outline-primary">
            Edit
        </a>

        <form action="{{ route('issues.destroy', $issue) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this issue?')">
            @csrf
            @method('DELETE')

            <button class="btn btn-sm btn-outline-danger">
                Delete
            </button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted py-4">
        No issues found.
    </td>
</tr>
@endforelse