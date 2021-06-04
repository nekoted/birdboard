<?php

namespace Tests\Feature;

use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_the_project_owner_can_invite_a_user()
    {
        $alice = User::factory()->create();
        $bob = User::factory()->create();
        $celine = User::factory()->create();

        $this->signIn($alice);
        $project = ProjectFactory::ownedBy($alice)->create();
        $response = $this->post($project->path() . '/invite', [
            'email' => $bob->email,
        ]);
        $response = $this->get($project->path());
        $response->assertSee('card-invite');
        Auth::logout();

        //A project member cannot invite another user
        $this->signIn($bob);
        $response = $this->post($project->path() . '/invite', [
            'email' => $celine->email,
        ]);
        $response->assertStatus(403);
        $this->assertCount(1, $project->members);
        $response = $this->get($project->path());
        $response->assertDontSee('card-invite');
        Auth::logout();

        //A user who is not a project member cannot invite another user
        $this->signIn($celine);
        $response = $this->post($project->path() . '/invite', [
            'email' => User::factory()->create()->email,
        ]);
        $response->assertStatus(403);
        $this->assertCount(1, $project->members);
        Auth::logout();
    }

    public function test_the_project_owner_can_invite_an_existing_user_to_the_project()
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

    public function test_the_project_owner_cannot_invite_a_user_already_member_of_the_project()
    {
        $user = $this->signIn();
        $invitedUser = User::factory()->create();
        $project = ProjectFactory::ownedBy($user)->create();
        $response = $this->post($project->path() . '/invite', [
            'email' => $invitedUser->email,
        ]);
        $this->assertCount(1, DB::table('project_members')->where('user_id', $invitedUser->id)->where('project_id', $project->id)->get());
        $response = $this->post($project->path() . '/invite', [
            'email' => $invitedUser->email,
        ]);
        $response->assertSessionHasErrors(['email' => 'This user is already a member of this project'], null, 'invitation');
        $this->assertCount(1, DB::table('project_members')->where('user_id', $invitedUser->id)->where('project_id', $project->id)->get());
        Auth::logout();
    }

    public function test_a_project_can_only_invite_existing_user()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->create();
        $response = $this->post($project->path() . '/invite', [
            'email' => 'nonexisting@user.com',
        ]);
        $response->assertSessionHasErrors(['email' => 'The user you are inviting must have an account'], null, 'invitation');
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
