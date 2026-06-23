@csrf

<div class="mb-3">
    <label class="form-label">Project</label>
    <select name="project_id" class="form-select @error('project_id') is-invalid @enderror">
        <option value="">Select project</option>
        @foreach ($projects as $project)
            <option value="{{ $project->id }}" @selected(old('project_id', request('project_id', $issue->project_id)) == $project->id)>
                {{ $project->name }}
            </option>
        @endforeach
    </select>
    @error('project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" value="{{ old('title', $issue->title) }}" class="form-control @error('title') is-invalid @enderror">
    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $issue->description) }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach (App\Models\Issue::STATUSES as $status)
                <option value="{{ $status }}" @selected(old('status', $issue->status ?? 'open') === $status)>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
            @endforeach
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Priority</label>
        <select name="priority" class="form-select @error('priority') is-invalid @enderror">
            @foreach (App\Models\Issue::PRIORITIES as $priority)
                <option value="{{ $priority }}" @selected(old('priority', $issue->priority ?? 'medium') === $priority)>
                    {{ ucfirst($priority) }}
                </option>
            @endforeach
        </select>
        @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Due Date</label>
        <input type="date" name="due_date" value="{{ old('due_date', $issue->due_date?->format('Y-m-d')) }}" class="form-control @error('due_date') is-invalid @enderror">
        @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<button class="btn btn-primary">Save Issue</button>
<a href="{{ route('issues.index') }}" class="btn btn-outline-secondary">Cancel</a>
