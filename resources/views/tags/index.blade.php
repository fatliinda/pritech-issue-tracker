@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="page-card mb-4">
            <h1 class="h4 mb-3">Create Tag</h1>

            <form action="{{ route('tags.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Color</label>
                    <input type="text" name="color" value="{{ old('color') }}" class="form-control @error('color') is-invalid @enderror" placeholder="#0d6efd">
                    @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary">Create Tag</button>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <div class="page-card">
            <h2 class="h4 mb-3">Tags</h2>

            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Color</th>
                        <th>Issues</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tags as $tag)
                        <tr>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->color ?? '-' }}</td>
                            <td>{{ $tag->issues_count }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">No tags found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $tags->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
