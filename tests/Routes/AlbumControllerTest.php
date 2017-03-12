<?php

use App\Models\User;
use App\Models\Album;
use App\Models\Image;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AlbumControllerTest extends TestCase
{
    use DatabaseMigrations;
    use TestHelpersTrait;

    public function testCreatorCanListOwnAlbums()
    {
        // Create a user with some uploaded images.
        $user = factory(User::class)->create();
        $user->albums()->saveMany(factory(Album::class, 20)->make());

        $this->seeInDatabase('albums', ['id' => 1]);

        $this->actingAsApiUser($user)->get('/api/albums');
        $this->assertResponseOk();
        $this->seeJson(['id' => 1]);
    }

    public function testUserCannotListAllAlbums()
    {
        $user = factory(User::class)->create();

        $this->actingAsApiUser($user)->get('/api/albums?all=1');
        $this->seeStatusCode(403);
    }

    public function testModCanListAllAlbums()
    {
        $mod = factory(User::class, 'moderator')->create();
        $other_user = factory(User::class)->create();
        $other_user->albums()->saveMany(factory(Album::class, 20)->make());

        $this->actingAsApiUser($mod)->get('/api/albums?all=1');
        $this->assertResponseOk();
        $this->seeJson(['id' => 12]);
    }

    public function testUserCanActionOwn()
    {
        $user = factory(User::class)->create();
        $user->albums()->saveMany(factory(Album::class, 20)->make());

        $this->actingAsApiUser($user)->put('/api/albums/12', ['name' => 'My album!']);
        $this->assertResponseOk();

        $this->seeJson(['id' => 12, 'name' => 'My album!']);
        $this->seeInDatabase('albums', ['id' => 12, 'name' => 'My album!']);
    }

    public function testUserCannotActionOther()
    {
        $user = factory(User::class)->create();
        $other_user = factory(User::class)->create();
        $other_user->albums()->saveMany(factory(Album::class, 20)->create());

        $this->actingAsApiUser($user)->put('/api/albums/15', ['name' => 'My album!']);
        $this->seeStatusCode(403);
        $this->notSeeInDatabase('albums', ['name' => 'My album!']);
    }

    public function testModCanActionOther()
    {
        $mod = factory(User::class, 'moderator')->create();
        $other_user = factory(User::class)->create();
        $other_user->albums()->saveMany(factory(Album::class, 20)->create());

        $this->actingAsApiUser($mod)->put('/api/albums/12', ['name' => 'My album!']);
        $this->assertResponseOk();

        $this->seeJson(['id' => 12, 'name' => 'My album!']);
        $this->seeInDatabase('albums', ['id' => 12, 'name' => 'My album!']);
    }

    public function testUserCanDeleteOwn()
    {
        $user = factory(User::class)->create();
        $user->albums()->saveMany(factory(Album::class, 20)->create());

        $this->actingAsApiUser($user)->delete('/api/albums/15');
        $this->assertResponseOk();
        $this->notSeeInDatabase('albums', ['id' => 15]);
    }

    public function testUserCannotDeleteOther()
    {
        $user = factory(User::class)->create();
        $other_user = factory(User::class)->create();
        $other_user->albums()->saveMany(factory(Album::class, 20)->create());

        $this->actingAsApiUser($user)->delete('/api/albums/15');
        $this->seeStatusCode(403);
        $this->seeInDatabase('albums', ['id' => 15]);
    }

    public function testModCanDeleteOther()
    {
        $mod = factory(User::class, 'moderator')->create();
        $other_user = factory(User::class)->create();
        $other_user->albums()->saveMany(factory(Album::class, 20)->create());

        $this->actingAsApiUser($mod)->delete('/api/albums/15');
        $this->assertResponseOk();
        $this->notSeeInDatabase('albums', ['id' => 15]);
    }
}
