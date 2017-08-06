<?php

namespace App\Models;


use App\Models\Traits\CreatorRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Storage;


class Image extends Model
{
    use CreatorRelation;

    protected $fillable = [
        'name',
        'description'
    ];

    public function album()
    {
        return $this->belongsTo('App\Models\Album');
    }

    public function getImageUrlAttribute()
    {
        return env('IMAGE_SERVER') . '/' . $this->filename;
    }

    public function getThumbUrlAttribute()
    {
        $search = ['{hostname}', '{filename}'];
        $replace = [env('IMAGE_SERVER'), $this->filename];

        return str_replace($search, $replace, env('THUMB_FORMAT'));
    }

    public static function fromUploadRequest(Request $request)
    {
        $file = $request->file('img');

        $newImage = new static();
        $newImage->filename = $file->getClientOriginalName();
        $newImage->uploader_ip = $request->ip();
        $newImage->uploadFile($file);
        $newImage->save();

        if ($request->user())
            $request->user()->images()->save($newImage);

        return $newImage;
    }

    public function uploadFile($file)
    {
        $this->filehash = md5_file($file);
        $this->filesize = filesize($file);

        if (!Storage::disk('s3')->has(split_to_path($this->filehash)))
        {
            $stream = fopen($file, 'r+');
            Storage::disk('s3')->writeStream(split_to_path($this->filehash), $stream);
            fclose($stream);
        }
    }

    /*
     * Upon a deletion event, this method is used to delete the image's file reference if it has become an orphan.
     * The deletion event is registered in AppServiceProvider::boot().
     */
    public function deleteFileIfOrphan()
    {
        if (static::whereFilehash($this->filehash)->count() == 0)
        {
            Storage::disk('s3')->delete(split_to_path($this->filehash));
        }
    }
}
