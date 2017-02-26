<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testJWTAuth()
    {
        $this->json('POST', '/api/auth/login', [
            'email' => 'admin@cubeupload.com',
            'password' => 'cubeupload'
        ])->seeJson([
            "message" => "token_generated"
        ]);
    }

    public function testCapability()
    {
        $adminUser = User::whereEmail('admin@cubeupload.com')->first();
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
