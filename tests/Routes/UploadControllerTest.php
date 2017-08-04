<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;

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
}
