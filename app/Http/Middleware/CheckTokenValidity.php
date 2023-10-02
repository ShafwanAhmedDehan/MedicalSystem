<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\authtoken;


class CheckTokenValidity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token)
        {
            return response()->json(['error' => 'No token Supplied']);
        }

        $tokenRecord = authtoken :: where('token', $token)->first();

        if (!$tokenRecord)
        {
            return response()->json(['error' => 'Wrong Token'], 401);
        }

        if ($tokenRecord->expires_at < (now()->addHours(6)))
        {
            return response()->json(['error' => 'Token has expired'], 401);
        }
         




        return $next($request);
    }
}
