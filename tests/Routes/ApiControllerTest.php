<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ApiControllerTest extends TestCase
{
    use DatabaseMigrations;
    use LoginTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testApiControllerAuth()
    {
        factory('App\Models\User', 'admin')->create();
        
        $this->assertLogin('testadmin@cubeupload.com', 'cube_test_admin');

        $this->get('/api')->assertResponseOk();
    }
}
