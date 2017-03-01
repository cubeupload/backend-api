<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testJWTAuth()
    {
        factory('App\Models\User', 'test_admin')->create();

        $this->json('POST', '/api/auth/login', [
            'email' => 'testadmin@cubeupload.com',
            'password' => 'cube_test_admin'
        ])->seeJson([
            "message" => "token_generated"
        ]);
    }

    public function testCapability()
    {
        factory('App\Models\User', 'test_admin')->create();
        factory('App\Models\User', 'test_mod')->create();
        factory('App\Models\User', 'test_user')->create();

        $adminUser = User::whereEmail('testadmin@cubeupload.com')->first();
        $this->assertTrue($adminUser->isAdmin());
        $this->assertTrue($adminUser->isModerator());

        $modUser = User::whereEmail('testmod@cubeupload.com')->first();
        $this->assertFalse($modUser->isAdmin());
        $this->assertTrue($modUser->isModerator());

        $testUser = User::whereEmail('testuser@cubeupload.com')->first();
        $this->assertFalse($testUser->isAdmin());
        $this->assertFalse($testUser->isModerator());
    }
}
