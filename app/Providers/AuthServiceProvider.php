<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Gate::define('modify-album', function($user, $album){
            if ($user->isModerator())
                return true;

            return $album->user_id == $user->id;
        });

        Gate::define('modify-ban', function($user, $ban){
            return $user->isModerator();
        });

        Gate::define('modify-image', function($user, $image){
            if ($user->isModerator())
                return true;

            return $image->user_id == $user->id;
        });

        Gate::define('modify-message', function($user, $message){
            return $user->isModerator();
        });

        Gate::define('modify-session', function($user, $session){
            return $user->isAdmin();
        });

        Gate::define('modify-user', function($user, $usr){
            if ($user->isModerator())
                return true;
            
            return $user->id == $usr->id;
        });

        Gate::define('delete-user', function($user, $usr){
            return $user->isAdmin();
        });
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });
    }
}
