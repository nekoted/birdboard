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

    public function test_a_project_can_invite_a_user(){
        $this->withoutExceptionHandling();

        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->create();
        $project->invite($anotherUser = User::factory()->create());
        Auth::logout();

        $this->signIn($anotherUser);
        $this->post($project->path().'/tasks', $task = ['body'=>'test task']);
        
        $this->assertDatabaseHas('tasks',$task);
    }
}
