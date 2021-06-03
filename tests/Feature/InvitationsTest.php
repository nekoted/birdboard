<?php

namespace Tests\Feature;

use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_the_project_owner_can_invite_a_user_to_the_project()
    {
        $alice = $this->signIn();
        $invitedUser = User::factory()->create();
        $project = ProjectFactory::ownedBy($alice)->create();
        Auth::logout();

        $bob = $this->signIn();
        $celine = User::factory()->create();
        $response = $this->post($project->path() . '/invite', [
            'email' => $celine->email,
        ]);
        $response->assertStatus(403);
        Auth::logout();
        
    }

    public function test_a_project_can_invite_a_user()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();
        $invitedUser = User::factory()->create();
        $project = ProjectFactory::ownedBy($user)->create();
        $response = $this->post($project->path() . '/invite', [
            'email' => $invitedUser->email,
        ]);
        $response->assertRedirect($project->path());
        Auth::logout();
        $this->assertTrue($project->members->contains($invitedUser));
    }

    public function test_a_project_can_only_invite_existing_user()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->create();
        $response = $this->post($project->path() . '/invite', [
            'email' => 'nonexisting@user.com',
        ]);
        $response->assertSessionHasErrors(['email' => 'The user you are invited must have an account']);
    }

    public function test_invited_users_in_a_project_can_add_tasks_to_the_project()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->create();
        $project->invite($anotherUser = User::factory()->create());
        Auth::logout();

        $this->signIn($anotherUser);
        $this->post($project->path() . '/tasks', $task = ['body' => 'test task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
