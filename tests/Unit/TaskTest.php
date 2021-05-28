<?php

namespace Tests\Unit;

use App\Models\Project;
use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_a_project()
    {
        $this->signIn();

        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    public function test_it_has_a_path()
    {
        $this->signIn();
        $task = Task::factory()->create();

        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    public function test_it_can_be_marked_as_complete()
    {
        $this->signIn();
        $task = Task::factory()->create();

        $this->assertFalse($task->completed);
        $task->complete();
        $this->assertTrue($task->completed);
    
    }
    public function test_it_can_be_marked_as_incomplete()
    {
        $this->signIn();
        $task = Task::factory()->create(['completed'=>true]);

        $this->assertTrue($task->completed);
        $task->incomplete();
        $this->assertFalse($task->completed);
    }
}
