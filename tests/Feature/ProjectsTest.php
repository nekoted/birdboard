<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test the ability for a user to create a project 
     *
     * @group dev
     * @return void
     */
    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $attributes = [
            "title" => $this->faker->sentence(),
            "description" => $this->faker->paragraph(),
        ];

        //Post a project
        $response = $this->post('/projects', $attributes);

        //Test redirect
        $response->assertRedirect('/projects');

        //Check if a the project has been created to the database
        $this->assertDatabaseHas('projects', $attributes);

        //Check if the project appears on the projects page
        $this->get('/projects')->assertSee($attributes['title']);
    }

    public function test_a_project_requires_a_title()
    {
        $this->actingAs(User::factory()->create());
        //Post a project
        $response = $this->post('/projects', Project::factory()->make(['title' => ''])->toArray());
        $response->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        $this->actingAs(User::factory()->create());
        //Post a project
        $response = $this->post('/projects', Project::factory()->make(['description' => ''])->toArray());
        $response->assertSessionHasErrors('description');
    }

    public function test_a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);
        $project = Project::factory()->for($user,'owner')->create();

        $response  = $this->get($project->path());
        $response->assertSee($project->title);
        $response->assertSee($project->description);
    }

    public function test_an_authenticated_user_cannot_view_a_project_of_another_user() {

        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

    public function test_guests_cannot_create_projects()
    {
        //$this->withoutExceptionHandling();
        $project = Project::factory()->make()->toArray();
        $response = $this->post('/projects', $project);
        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_guests_cannot_view_projects()
    {
        $this->get('/projects')->assertRedirect('/login');
    }

    public function test_guests_cannot_view_a_single_project()
    {
        $project = Project::factory()->create();
        $this->get($project->path())->assertRedirect('/login');
    }

    
}
