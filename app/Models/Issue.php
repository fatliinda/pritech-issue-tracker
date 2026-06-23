<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    use HasFactory;

    public const STATUSES = ['open', 'in_progress', 'closed'];
    public const PRIORITIES = ['low', 'medium', 'high'];

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['status'] ?? null, function (Builder $query, string $status): void {
                $query->where('status', $status);
            })
            ->when($filters['priority'] ?? null, function (Builder $query, string $priority): void {
                $query->where('priority', $priority);
            })
            ->when($filters['tag'] ?? null, function (Builder $query, string $tagId): void {
                $query->whereHas('tags', function (Builder $tagQuery) use ($tagId): void {
                    $tagQuery->where('tags.id', $tagId);
                });
            })
            ->when($filters['search'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            });
    }
}
