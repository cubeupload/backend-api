<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class PermissionsTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserLevels()
    {
        factory(User::class, 'admin')->create();
        factory(User::class, 'moderator')->create();
        factory(User::class)->create();

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
