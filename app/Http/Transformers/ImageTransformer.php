<?php namespace App\Http\Transformers;

use App\Models\Image;
use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{
    public function transform(Image $image)
    {
        return [
            'filename' => $image->filename,
            'links' => [
                'img' => $image->imageUrl,
                'thumb' => $image->thumbUrl
            ]
        ];
    }
}

