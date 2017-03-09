<?php

use App\Models\User;
use App\Models\Image;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ImageControllerTest extends TestCase
{
    use DatabaseMigrations;
    use LoginTrait;



    public function testCreatorCanListOwnImages()
    {
        // Create a user with some uploaded images.
        $user = factory(User::class)->create();
        $user->each(function($u){
            $u->images()->saveMany(factory(Image::class, 20)->make());
        });

        $this->actingAsApiUser($user)->get('/api/images');

        $this->seeInDatabase('images', ['id' => 1]);
        $this->seeJson(['id' => 1]);
    }

    /*

    public function testUserCanCreate()
    {

    }

    public function testUserCanActionOwn()
    {

    }

    public function testUserCannotActionOther()
    {

    }

    public function testModCanActionOther()
    {

    }

    public function testModCanDeleteOther()
    {

    }
    
    */
}
