@csrf

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" value="{{ old('name', $project->name) }}" class="form-control @error('name') is-invalid @enderror">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $project->description) }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}" class="form-control @error('start_date') is-invalid @enderror">
        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Deadline</label>
        <input type="date" name="deadline" value="{{ old('deadline', $project->deadline?->format('Y-m-d')) }}" class="form-control @error('deadline') is-invalid @enderror">
        @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<button class="btn btn-primary">Save Project</button>
<a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">Cancel</a>
