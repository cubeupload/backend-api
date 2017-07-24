<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Ban;
use Cache;
use Illuminate\Http\JsonResponse;


/*
    The BanCheck middleware takes the incoming request and checks the bans table for any matching entries.

    The middleware can be called multiple times as the request state changes, usually once for unauthenticated and again after authentication.
*/
class BanCheck
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
        $ban = $this->getBanMatchingRequest($request);

        if ($ban != null)
            return new JsonResponse([
            'message' => 'Request forbidden due to a ban being in place.',
            'reason' => $ban->reason,
            'expires' => $ban->expires_at
        ], 403);

        $response = $next($request);

        return $response;
    }

   public function getBanMatchingRequest($request)
    {
        // Check for any bans on the request IP.
        $ip_ban = Cache::remember('bans:' . $request->server('REMOTE_ADDR'), env('CACHE_REMEMBER_MINUTES'), function() use ($request){
            return Ban::whereBannedIp($request->server('REMOTE_ADDR'))->active()->first();
        });

        if ($ip_ban != null)
            return $ip_ban;

        // Don't bother looking for a user ban if the request wasn't authed.
        if ($request->user() == null)
            return null;

        // Check for any bans on the authed user.
        $user_ban = Cache::remember('bans:' . $request->user()->id, env('CACHE_REMEMBER_MINUTES'), function() use ($request){
            return Ban::whereRecipientId($request->user()->id)->active()->first();
        });

        if ($user_ban != null)
            return $user_ban;

        // If we've come this far there are no bans.
        return null;
    }
}
