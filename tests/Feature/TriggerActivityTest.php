<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Activity;
use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activities);
        $this->assertDatabaseHas('activities', ['description' => 'created']);
    }

    public function test_updating_a_project()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertDatabaseHas('activities', ['description' => 'updated', 'project_id' => $project->id]);
    }

    public function test_creating_a_new_task()
    {
        $project = ProjectFactory::create();

        $project->addTask('test task');

        $this->assertDatabaseHas('activities', ['description' => 'created_task', 'project_id' => $project->id]);

        //dd($project->activities->toArray());

        tap($project->activities->last(), function ($activity) {

            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    public function test_completing_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), ['body' => 'test task', 'completed' => true]);

        $this->assertDatabaseHas('activities', ['description' => 'completed_task', 'project_id' => $project->id]);

        tap($project->activities->last(), function ($activity) {
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    public function test_incompleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();


        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), ['body' => 'test task', 'completed' => true]);

        $this->assertDatabaseHas('activities', ['description' => 'completed_task', 'project_id' => $project->id]);

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), ['body' => 'test task']);

        $this->assertDatabaseHas('activities', ['description' => 'incompleted_task', 'project_id' => $project->id]);

        tap($project->activities->last(), function ($activity) {
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    public function test_deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertDatabaseHas('activities', ['description' => 'deleted_task', 'project_id' => $project->id]);
    }
}
