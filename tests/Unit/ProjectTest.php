<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_has_a_path()
    {
        $project = Project::factory()->create();
        $this->assertTrue(("/projects/{$project->id}" === $project->path()));
    }

    public function test_a_project_belongs_to_an_owner()
    {
        $project = Project::factory()->create();
        $this->assertInstanceOf(User::class, $project->owner);
    }
}
