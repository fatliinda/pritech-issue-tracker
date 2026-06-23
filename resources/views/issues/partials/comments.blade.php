@forelse ($comments as $comment)
    @include('issues.partials.comment', ['comment' => $comment])
@empty
    <p class="text-muted">No comments yet.</p>
@endforelse
