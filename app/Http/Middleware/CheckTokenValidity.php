<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\authtoken;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckTokenValidity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, /*$role*/): Response
    {
        $token = $request->bearerToken();
        if (!$token)
        {
            return response()->json(['error' => 'No token Supplied']);
        }

        $tokenRecord = authtoken :: where('token', $token)->first();

        //$userinfo = User :: where ('id', $tokenRecord->user_id)->first();


        if (!$tokenRecord)
        {
            return response()->json(['error' => 'Wrong Token'], 401);
        }

        if ($tokenRecord->expires_at < (now()->addHours(6)))
        {
            return response()->json(['error' => 'Token has expired'], 401);
        }

        /*else
        {
            if ($userinfo->role === (int)$role)
            {
                return $next($request);
            }
            if ($userinfo->role === (int)$role)
            {
                return $next($request);
            }
            if ($userinfo->role === (int)$role)
            {
                return $next($request);
            }
            if ($userinfo->role === (int)$role)
            {
                return $next($request);
            }
            else
            {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }*/

        return $next($request);
    }
}
