<?php

namespace App\Jobs;

use Storage;

class S3FileUploadJob extends Job
{
    public $hash;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($hash)
    {
        $this->hash = $hash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $hash_path = split_to_path($this->hash);
        $fn = storage_path() . '/app/' . $hash_path;

        if (!Storage::disk('s3')->has($hash_path))
        {
            $stream = fopen($fn, 'r+');
            Storage::disk('s3')->writeStream($hash_path, $stream);
            fclose($stream);
        }

        Storage::delete($hash_path);
    }
}
