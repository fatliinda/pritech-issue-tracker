@extends('layouts.app')

@section('content')
<div class="page-card">
    <h1 class="h3 mb-4">Create Project</h1>
    <form action="{{ route('projects.store') }}" method="POST">
        @include('projects._form')
    </form>
</div>
@endsection
