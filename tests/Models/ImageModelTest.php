<?php

use App\Models\Album;
use App\Models\AbuseReport;
use App\Models\Ban;
use App\Models\Image;
use App\Models\User;

use Laravel\Lumen\Testing\DatabaseMigrations;

class ImageModelTest extends TestCase
{

    use DatabaseMigrations;

    public function testImageUserRelationship()
    {
        factory(Image::class)->create();
        factory(User::class)->create();

        $user = User::find(1);
        $image = Image::find(1);

        $image->creator()->associate($user);

        $this->assertEquals(1, $image->creator_id);
    }

    public function testImageAlbumRelationship()
    {
        factory(Image::class)->create();
        factory(Album::class)->create();

        $image = Image::find(1);
        $album = Album::find(1);

        $image->album()->associate($album);

        $this->assertEquals(1, $image->album_id);
    }
}
