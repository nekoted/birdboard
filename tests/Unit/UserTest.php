<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_has_projects()
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    public function test_a_user_has_accessible_projects(){

        $alice = User::factory()->create();
        $bob = User::factory()->create();
        $celine = User::factory()->create();
        

        $this->signIn($alice);
        $project_alice = ProjectFactory::ownedBy($alice)->create();
        $project_alice->invite($bob);
        $this->assertCount(1,$alice->accessibleProjects());
        Auth::logout();
        
        $this->signIn($bob);
        $this->assertCount(1,$bob->accessibleProjects());
        Auth::logout();
        
        $this->signIn($celine);
        $this->assertCount(0,$celine->accessibleProjects());
        Auth::logout();

    }
}
