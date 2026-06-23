@extends('layouts.app')

@section('content')
<div class="page-card">
    <h1 class="h3 mb-4">Edit Issue</h1>
    <form action="{{ route('issues.update', $issue) }}" method="POST">
        @method('PUT')
        @include('issues._form')
    </form>
</div>
@endsection
