<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test the ability for a user to create a project 
     *
     * @return void
     */
    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            "title" => $this->faker->sentence(),
            "description" => $this->faker->paragraph(),
        ];
        
        //Post a project
        $response = $this->post('/projects',$attributes);

        //Test redirect
        $response->assertRedirect('/projects');

        //Check if a the project has been created to the database
        $this->assertDatabaseHas('projects',$attributes);

        //Check if the project appears on the projects page
        $this->get('/projects')->assertSee($attributes['title']);
    }
}
