<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertTrue;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_has_a_path()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $this->assertTrue(("/projects/{$project->id}" === $project->path()));
    }

    public function test_a_project_belongs_to_an_owner()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $this->assertInstanceOf(User::class, $project->owner);
    }

    public function test_a_project_can_add_a_task(){
        $this->signIn();

        $project = Project::factory()->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1,$project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }

    public function test_a_project_can_invite_a_user(){
        $this->signIn();
        $project = Project::factory()->create();
        
        $project->invite($anotherUser = User::factory()->create());

        $this->assertTrue($project->members->contains($anotherUser));
    }
}
