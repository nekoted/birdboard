<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;



    public function test_guests_cannot_manage_projects()
    {
        $project = Project::factory()->create();
        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    /**
     * Test the ability for a user to create a project 
     *
     * @group dev
     * @return void
     */
    public function test_a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            "title" => $this->faker->sentence(),
            "description" => $this->faker->sentence(),
            "notes" => "My notes",
        ];

        //Post a project
        $response = $this->post('/projects', $attributes);

        //Test redirect
        $project = Project::first();
        $response->assertRedirect($project->path());

        //Check if the project appears on the projects page
        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    public function test_a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $attributes = ['notes' => 'Changed'];
        $response = $this->actingAs($project->owner)->patch($project->path(), $attributes);

        //Test redirect
        $response->assertRedirect($project->path());

        //Check if a the project has been created to the database
        $this->assertDatabaseHas('projects', $attributes);
    }

    public function test_a_project_requires_a_title()
    {
        $this->signIn();

        //Post a project
        $response = $this->post('/projects', Project::factory()->make(['title' => ''])->toArray());
        $response->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        //$this->withoutExceptionHandling();

        $this->signIn();

        //Post a project
        $response = $this->post('/projects', Project::factory()->make(['description' => ''])->toArray());
        $response->assertSessionHasErrors('description');
    }

    public function test_a_user_can_view_their_project()
    {
        $project = ProjectFactory::create();

        $response  = $this->actingAs($project->owner)->get($project->path());
        $response->assertSee($project->title);
        $response->assertSee($project->description);
    }

    public function test_an_authenticated_user_cannot_view_a_project_of_another_user()
    {

        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

    public function test_an_authenticated_user_cannot_update_a_project_of_another_user()
    {

        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path())->assertStatus(403);
    }

    public function test_an_authenticated_user_cannot_view_projects_of_another_user()
    {

        $this->signIn();

        $project = Project::factory()->create();

        $this->get('/projects')->assertDontSee($project->title);
    }
}
