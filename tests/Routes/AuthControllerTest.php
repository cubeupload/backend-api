<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;
    use TestHelpersTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAuthControllerLogin()
    {
        $admin = factory(User::class, 'admin')->create();
        
        $this->assertLogin('testadmin@cubeupload.com', 'cube_test_admin');

        $this->get('/api')->assertResponseOk();
    }
}
