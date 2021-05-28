<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;


    public function test_guests_cannot_add_task_to_projects()
    {
        $this->signIn();
        $project = Project::factory()->create();
        Auth::logout();

        $response = $this->post($project->path() . '/tasks');
        $response->assertRedirect('/login');
    }

    public function test_only_the_owner_of_the_project_can_add_tasks()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $response = $this->post($project->path() . '/tasks', ['body' => 'Test task']);
        $response->assertForbidden();

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    public function test_only_the_owner_of_the_project_can_update_tasks()
    {

        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $response = $this->patch($project->tasks->first()->path(), ['body' => 'changed']);
        $response->assertForbidden();

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    public function test_a_project_can_have_tasks()
    {
        $this->signIn();

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    public function test_a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
        
        $attributes_changed = ['body' => 'changed', 'completed' => true];
        $this->patch($project->tasks->first()->path(), $attributes_changed);
        $this->assertDatabaseHas('tasks', $attributes_changed);
    }

    public function test_a_task_requires_a_body()
    {
        $this->signIn();

        $project = ProjectFactory::create();

        $attributes = Task::factory()->make(['body' => ''])->toArray();
        //Post a task
        $response = $this->actingAs($project->owner)->post($project->path() . '/tasks', $attributes);
        $response->assertSessionHasErrors('body');
    }

    public function test_a_task_can_be_marked_as_complete(){
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $task = $project->tasks[0];

        $this->assertDatabaseHas('tasks',['completed'=>false]);
        $this->actingAs($project->owner)->patch($task->path(),['body'=>'test task','completed'=>true]);
        $this->assertDatabaseHas('tasks',['completed'=>true]);
    }

    public function test_a_task_can_be_marked_as_incomplete(){

        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $task = $project->tasks[0];

        $this->actingAs($project->owner)->patch($task->path(),['body'=>'test task','completed'=>true]);
        $this->assertDatabaseHas('tasks',['completed'=>true]);
        $this->actingAs($project->owner)->patch($task->path(),['body'=>'test task','completed'=>false]);
        $this->assertDatabaseHas('tasks',['completed'=>false]);
    }
}
