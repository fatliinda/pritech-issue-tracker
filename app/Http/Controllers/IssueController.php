<?php

namespace App\Http\Controllers;

use App\Http\Requests\IssueRequest;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index(Request $request): View
    {
        $issues = Issue::query()
            ->with(['project', 'tags'])
            ->withCount('comments')
            ->filter($request->only(['status', 'priority', 'tag', 'search']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('issues.index', [
            'issues' => $issues,
            'tags' => Tag::query()->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('issues.create', [
            'issue' => new Issue(['status' => 'open', 'priority' => 'medium']),
            'projects' => Project::query()->orderBy('name')->get(),
        ]);
    }

    public function store(IssueRequest $request): RedirectResponse
    {
        $issue = Issue::create($request->validated());

        return redirect()
            ->route('issues.show', $issue)
            ->with('success', 'Issue created successfully.');
    }

    public function show(Issue $issue): View
    {
        $issue->load(['project', 'tags']);

        $attachedTagIds = $issue->tags->pluck('id');

        $availableTags = Tag::query()
            ->whereNotIn('id', $attachedTagIds)
            ->orderBy('name')
            ->get();

        return view('issues.show', compact('issue', 'availableTags'));
    }

    public function edit(Issue $issue): View
    {
        return view('issues.edit', [
            'issue' => $issue,
            'projects' => Project::query()->orderBy('name')->get(),
        ]);
    }

    public function update(IssueRequest $request, Issue $issue): RedirectResponse
    {
        $issue->update($request->validated());

        return redirect()
            ->route('issues.show', $issue)
            ->with('success', 'Issue updated successfully.');
    }

    public function destroy(Issue $issue): RedirectResponse
    {
        $issue->delete();

        return redirect()
            ->route('issues.index')
            ->with('success', 'Issue deleted successfully.');
    }
    public function search(Request $request)
    {
        $search = trim($request->query('q', ''));

        $issues = Issue::with(['project', 'tags'])
            ->withCount('comments')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('issues.partials.rows', compact('issues'))->render();
    }
}
