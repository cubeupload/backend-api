<?php

use App\Models\Album;
use App\Models\AbuseReport;
use App\Models\Ban;
use App\Models\Image;
use App\Models\User;

use Laravel\Lumen\Testing\DatabaseMigrations;

class AlbumModelTest extends TestCase
{

    use DatabaseMigrations;

    public function testAlbumUserRelationship()
    {
        factory('App\Models\Album')->create();
        factory('App\Models\User')->create();

        $user = User::find(1);
        $album = Album::find(1);

        $album->creator()->associate($user);

        $this->assertEquals(1, $album->creator_id);
    }

    public function testAlbumImageRelationship()
    {
        factory('App\Models\Image')->create();
        factory('App\Models\Album')->create();

        $image = Image::find(1);
        $album = Album::find(1);

        $album->images()->save($image);

        $this->assertEquals(1, $image->album_id);
    }
}
