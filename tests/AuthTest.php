<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
#use LoginTrait;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
    use \LoginTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAuthentication()
    {
        factory('App\Models\User', 'admin')->create();

        $this->assertLogin('testadmin@cubeupload.com', 'cube_test_admin');
    }

    public function testCapability()
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
