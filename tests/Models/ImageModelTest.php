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

    public function testFileAttributes()
    {
        $stub = __DIR__.'/../stubs/testimage.png';
        $image = factory(Image::class)->create();
        $image->uploadFile($stub);

        $expected_hash = md5_file($stub);
        $expected_size = filesize($stub);

        $this->assertEquals($expected_hash, $image->filehash);
        $this->assertEquals($expected_size, $image->filesize);
    }

    public function testFileDeletionEvent()
    {
        $stub = __DIR__.'/../stubs/testimage.png';
        $stub_md5 = md5_file($stub);
        $stub_splitpath = split_to_path($stub_md5);

        $imgs = factory(Image::class, 3)->create(['filehash' => $stub_md5]);
        $imgs[0]->uploadFile($stub);

        $imgs[2]->delete();
        $this->assertEquals(true, Storage::disk('s3')->has($stub_splitpath));

        $imgs[1]->delete();
        $this->assertEquals(true, Storage::disk('s3')->has($stub_splitpath));

        $imgs[0]->delete();
        $this->assertEquals(false, Storage::disk('s3')->has($stub_splitpath));
    }
}
