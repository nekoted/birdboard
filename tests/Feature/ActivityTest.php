<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Activity;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_project_generates_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activities);
        $this->assertDatabaseHas('activities', ['description' => 'created']);
    }

    public function test_updating_a_project_generates_activity()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertDatabaseHas('activities', ['description' => 'updated', 'project_id' => $project->id]);
    }
}
