<?php

namespace Tests\Unit;

use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_has_a_owner(){
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->create();

        $this->assertEquals($user->id, $project->activities->first()->user->id);
    }
}
