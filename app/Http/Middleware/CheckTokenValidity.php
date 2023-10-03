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
    public function handle(Request $request, Closure $next)
    {
        if ($jwt = $request->cookie('jwt'))
        {
            $request->headers->set('Authorization', 'Bearer ' . $jwt);
        }

        $token = $request->bearerToken();

        if (!$token)
        {
            return response()->json(['error' => 'no token provided']);
        }

        $tokenRecord = authtoken::where('token', $token)->first();
    
        if (!$tokenRecord) 
        {
            return response()->json(['error' => 'invalid token']);
        }

        if ($tokenRecord->expires_at < (now()->addHours(6)))
        {
            $this->destroyToken($tokenRecord);
            return response()->json(['error' => 'token has expired']);
        }

        return $next($request);
    }

    public function destroyToken(authtoken $tokenRec)
    {
        $tokenRec->delete();
    }
}
