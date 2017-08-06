<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

use App\Models\Image;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Image::deleted(function ($img){
            $img->deleteFileIfOrphan();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->make('api.exception')->register(function (AuthorizationException $e){
            abort(403, $e->getMessage());
        });
        app()->make('api.exception')->register(function (ValidationException $e){
            abort(412, $e->getMessage());
        });
        app()->make('api.exception')->register(function (ModelNotFoundException $e){
            abort(404, 'Not Found.');
        });
    }
}
