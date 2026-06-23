<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::factory()->count(10)->create();

        Project::factory()
            ->count(5)
            ->create()
            ->each(function (Project $project) use ($tags): void {
                Issue::factory()
                    ->count(8)
                    ->create([
                        'project_id' => $project->id,
                    ])
                    ->each(function (Issue $issue) use ($tags): void {
                        $issue->tags()->attach(
                            $tags->random(random_int(1, 3))->pluck('id')->all()
                        );

                        Comment::factory()
                            ->count(random_int(1, 5))
                            ->create([
                                'issue_id' => $issue->id,
                            ]);
                    });
            });
    }
}
