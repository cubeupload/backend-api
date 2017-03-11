<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserLevels()
    {
        factory('App\Models\User', 'admin')->create();
        factory('App\Models\User', 'moderator')->create();
        factory('App\Models\User')->create();

        $adminUser = User::find(1);
        $this->assertTrue($adminUser->isAdmin());
        $this->assertTrue($adminUser->isModerator());

        $modUser = User::find(2);
        $this->assertFalse($modUser->isAdmin());
        $this->assertTrue($modUser->isModerator());

        $testUser = User::find(3);
        $this->assertFalse($testUser->isAdmin());
        $this->assertFalse($testUser->isModerator());
    }
}
