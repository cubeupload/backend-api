<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;
    use LoginTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserListing()
    {
        // Test success
        $user = factory('App\Models\User', 'admin')->create();
        factory('App\Models\User', 10)->create();

        $this->actingAsApiUser($user)->get('/api/users');
        
        $this->assertResponseOk();
        $this->seeJson([
            'total' => 11, 
            'per_page' => 30, 
            'id' => 1
        ]);

        // Refresh the app to clear previous requests.
        $this->refreshApplication();

        // Make sure unauthenticated requests are refused.
        $this->get('/api/users')->seeStatusCode(401);
    }

    public function testAdminCanCreate()
    {
        $user = factory('App\Models\User', 'admin')->create();

        $new_user = [
            'email' => 'testcreation@cubeupload.com',
            'name' => 'Test Created User'
        ];

        $this->actingAsApiUser($user)->post('/api/users', $new_user);
        $this->assertResponseOk();

        $this->seeInDatabase('users', ['email' => 'testcreation@cubeupload.com']);

        $this->refreshApplication();

        $this->post('/api/users', $new_user)->seeStatusCode(401);
    }

    public function testUserCannotCreate()
    {
        $user = factory(User::class)->create();

        $new_user = [
            'email' => 'testcreation@cubeupload.com',
            'name' => 'Test Created User'
        ];

        $this->actingAsApiUser($user)->post('/api/users', $new_user);
        $this->seeStatusCode(403);
    }

    public function testUserCanActionSelf()
    {
        $user = factory(User::class)->create();

        $this->actingAsApiUser($user)->get('/api/users/1')->seeJson(['id' => 1]);

        $this->refreshApplication();

        $this->actingAsApiUser($user)->put('/api/users/1', ['name' => 'Jeremy Kyle']);
        $this->seeInDatabase('users', ['name' => 'Jeremy Kyle']);
    }

    public function testUserCannotActionOther()
    {
        $user = factory(User::class)->create();
        factory(User::class)->create();

        $this->actingAsApiUser($user)->get('/api/users/2')->seeStatusCode(403);
    }

    public function testModCanActionOther()
    {
        $mod = factory(User::class, 'moderator')->create();
        factory(User::class)->create();

        $this->actingAsApiUser($mod)->get('/api/users/2')->seeJson(['id' => 2]);
    }
}
