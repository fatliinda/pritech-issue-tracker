@extends('layouts.app')

@section('content')
<div class="page-card">
    <h1 class="h3 mb-4">Edit Project</h1>
    <form action="{{ route('projects.update', $project) }}" method="POST">
        @method('PUT')
        @include('projects._form')
    </form>
</div>
@endsection
