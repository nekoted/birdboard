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

    public function test_creating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activities);
        $this->assertDatabaseHas('activities', ['description' => 'created']);
    }

    public function test_updating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertDatabaseHas('activities', ['description' => 'updated', 'project_id' => $project->id]);
    }

    public function test_creating_a_new_task_records_project_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask('test task');

        $this->assertDatabaseHas('activities', ['description' => 'created_task', 'project_id' => $project->id]);
    }

    public function test_completing_a_task_records_project_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), ['body' => 'test task', 'completed' => true]);

        $this->assertDatabaseHas('activities', ['description' => 'completed_task', 'project_id' => $project->id]);
    }
}
