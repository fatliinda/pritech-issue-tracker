<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachTagRequest;
use App\Models\Issue;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class IssueTagController extends Controller
{
    public function store(AttachTagRequest $request, Issue $issue): JsonResponse
    {
        $issue->tags()->syncWithoutDetaching([
            $request->integer('tag_id'),
        ]);

        return $this->tagPayload($issue, 'Tag attached successfully.');
    }

    public function destroy(Issue $issue, Tag $tag): JsonResponse
    {
        $issue->tags()->detach($tag->id);

        return $this->tagPayload($issue, 'Tag detached successfully.');
    }

    private function tagPayload(Issue $issue, string $message): JsonResponse
    {
        $issue->load('tags');

        $availableTags = Tag::query()
            ->whereNotIn('id', $issue->tags->pluck('id'))
            ->orderBy('name')
            ->get(['id', 'name', 'color']);

        return response()->json([
            'message' => $message,
            'tags' => $issue->tags->map(fn (Tag $tag) => [
                'id' => $tag->id,
                'name' => $tag->name,
                'color' => $tag->color,
            ])->values(),
            'available_tags' => $availableTags,
        ]);
    }
}
