<div class="border rounded p-3 mb-2 bg-white">
    <div class="d-flex justify-content-between">
        <strong>{{ $comment->author_name }}</strong>
        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
    </div>
    <p class="mb-0 mt-2">{{ $comment->body }}</p>
</div>
