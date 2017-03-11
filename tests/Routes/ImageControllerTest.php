<?php

use App\Models\User;
use App\Models\Image;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ImageControllerTest extends TestCase
{
    use DatabaseMigrations;
    use TestHelpersTrait;

    public function testCreatorCanListOwnImages()
    {
        // Create a user with some uploaded images.
        $user = factory(User::class)->create();
        $user->images()->saveMany(factory(Image::class, 20)->make());

        $this->seeInDatabase('images', ['id' => 1]);

        $this->actingAsApiUser($user)->get('/api/images');
        $this->assertResponseOk();
        $this->seeJson(['id' => 1]);
    }

    public function testUserCannotListAllImages()
    {
        $user = factory(User::class)->create();

        $this->actingAsApiUser($user)->get('/api/images?all=1');
        $this->seeStatusCode(403);
    }

    public function testModCanListAllImages()
    {
        $mod = factory(User::class, 'moderator')->create();
        $other_user = factory(User::class)->create();
        $other_user->images()->saveMany(factory(Image::class, 20)->make());

        $this->actingAsApiUser($mod)->get('/api/images?all=1');
        $this->assertResponseOk();
        $this->seeJson(['id' => 12]);
    }

    public function testUserCanActionOwn()
    {
        $user = factory(User::class)->create();
        $user->images()->saveMany(factory(Image::class, 20)->make());

        $this->actingAsApiUser($user)->put('/api/images/12', ['name' => 'My image!']);
        $this->assertResponseOk();

        $this->seeJson(['id' => 12, 'name' => 'My image!']);
        $this->seeInDatabase('images', ['id' => 12, 'name' => 'My image!']);
    }

    public function testUserCannotActionOther()
    {
        $user = factory(User::class)->create();
        $other_user = factory(User::class)->create();
        $other_user->each(function($u){
            $u->images()->saveMany(factory(Image::class, 20)->create());
        });

        // Created 40 images above, 21+ belongs to $other_user.
        $this->actingAsApiUser($user)->put('/api/images/25', ['name' => 'My image!']);
        $this->seeStatusCode(403);
        $this->notSeeInDatabase('images', ['name' => 'My image!']);
    }

    public function testModCanActionOther()
    {
        $mod = factory(User::class, 'moderator')->create();
        $other_user = factory(User::class)->create();
        $other_user->each(function($u){
            $u->images()->saveMany(factory(Image::class, 20)->create());
        });

        $this->actingAsApiUser($mod)->put('/api/images/12', ['name' => 'My image!']);
        $this->assertResponseOk();

        $this->seeJson(['id' => 12, 'name' => 'My image!']);
        $this->seeInDatabase('images', ['id' => 12, 'name' => 'My image!']);
    }

    public function testUserCanDeleteOwn()
    {
        $user = factory(User::class)->create();
        $user->images()->saveMany(factory(Image::class, 20)->create());

        $this->actingAsApiUser($user)->delete('/api/images/15');
        $this->assertResponseOk();
        $this->notSeeInDatabase('images', ['id' => 15]);
    }

    public function testUserCannotDeleteOther()
    {
        $user = factory(User::class)->create();
        $other_user = factory(User::class)->create();
        $other_user->images()->saveMany(factory(Image::class, 20)->create());

        $this->actingAsApiUser($user)->delete('/api/images/15');
        $this->seeStatusCode(403);
        $this->seeInDatabase('images', ['id' => 15]);
    }

    public function testModCanDeleteOther()
    {
        $mod = factory(User::class, 'moderator')->create();
        $other_user = factory(User::class)->create();
        $other_user->images()->saveMany(factory(Image::class, 20)->create());

        $this->actingAsApiUser($mod)->delete('/api/images/15');
        $this->assertResponseOk();
        $this->notSeeInDatabase('images', ['id' => 15]);
    }
}
