<?php

namespace App\Http\Middleware;

use Closure;
use Validator;
use Illuminate\Http\JsonResponse;

/*
    The UploadCheck middleware uses a validator to make sure files being sent to us are legit.
    On a basic level this is:
    
        1. Making sure the file extension is allowed
        2. The file mimetype/content matches the extension
        3. The file isn't too big

    This could be expanded to include ClamAV scanning.

*/

class UploadCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validator = Validator::make($request->all(),[
            'img' => 'file|image|max:500|required|mimes:jpg,jpeg,bmp,png,svg'
        ]);

        if ($validator->fails())
        {
            return new JsonResponse([
                'message' => 'The uploaded file failed validation.',
                'reasons' => $validator->errors()->all()
            ], 400);
        }

        $response = $next($request);

        return $response;
    }
}
