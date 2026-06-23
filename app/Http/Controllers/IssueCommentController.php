<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Http\JsonResponse;

class IssueCommentController extends Controller
{
    public function index(Issue $issue): JsonResponse
    {
        $comments = $issue->comments()->paginate(5);

        return response()->json([
            'html' => view('issues.partials.comments', compact('comments'))->render(),
            'pagination' => $comments->links()->render(),
        ]);
    }

    public function store(CommentRequest $request, Issue $issue): JsonResponse
    {
        /** @var Comment $comment */
        $comment = $issue->comments()->create($request->validated());

        return response()->json([
            'message' => 'Comment added successfully.',
            'html' => view('issues.partials.comment', compact('comment'))->render(),
        ], 201);
    }
}
