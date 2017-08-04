<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use App\Models\User;

class UploadControllerTest extends TestCase
{
    use DatabaseMigrations;
    use TestHelpersTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGuestUploadSuccess()
    {
        $path = __DIR__.'/../stubs/testimage.png';
        $file = new UploadedFile($path, 'testimage.png', filesize($path), 'image/png', null, true);
        $this->call('POST', '/api/upload/guest', [], [], ['img' => $file], ['Content-Type' => 'multipart/form-data']);

        $this->assertResponseOk();

        $this->seeJson([
           'filename' => 'testimage.png',
           'id' => 1,
           'uploader_ip' => '127.0.0.1'
        ]);
    }

    public function testAuthedUploadSuccess()
    {
        $user = factory(User::class)->create();
        $path = __DIR__.'/../stubs/testimage.png';

        $file = new UploadedFile($path, 'testimage.png', filesize($path), 'image/png', null, true);
        $this->actingAsApiUser($user)->call('POST', '/api/upload/authed', [], [], ['img' => $file], ['Content-Type' => 'multipart/form-data']);

        $this->assertResponseOk();

        $this->seeJson([
           'filename' => 'testimage.png',
           'id' => 1,
           'uploader_ip' => '127.0.0.1',
           'creator_id' => 1
        ]);
    }

    public function testGuestUploadForbiddenFiletype()
    {
        $path = __DIR__.'/../stubs/testplaintext.txt';

        $file = new UploadedFile($path, 'testplaintext.txt', filesize($path), 'text/plain', null, true);
        $this->call('POST', '/api/upload/guest', [], [], ['img' => $file], ['Content-Type' => 'multipart/form-data']);

        $this->seeStatusCode(400);
    }

    public function testUserUploadForbiddenFiletype()
    {
        $user = factory(User::class)->create();
        $path = __DIR__.'/../stubs/testplaintext.txt';

        $file = new UploadedFile($path, 'testplaintext.txt', filesize($path), 'text/plain', null, true);
        $this->actingAsApiUser($user)->call('POST', '/api/upload/guest', [], [], ['img' => $file], ['Content-Type' => 'multipart/form-data']);

        $this->seeStatusCode(400);
    }

    public function testGuestUploadWrongFileExtension()
    {
        $path = __DIR__.'/../stubs/testplaintext.txt';

        $file = new UploadedFile($path, 'testfakeimage.png', filesize($path), 'image/png', null, true);
        $this->call('POST', '/api/upload/guest', [], [], ['img' => $file], ['Content-Type' => 'multipart/form-data']);

        $this->seeStatusCode(400);
    }

    public function testUserUploadWrongFileExtension()
    {
        $user = factory(User::class)->create();
        $path = __DIR__.'/../stubs/testplaintext.txt';

        $file = new UploadedFile($path, 'testfakeimage.png', filesize($path), 'image/png', null, true);
        $this->actingAsApiUser($user)->call('POST', '/api/upload/guest', [], [], ['img' => $file], ['Content-Type' => 'multipart/form-data']);

        $this->seeStatusCode(400);
    }
}
