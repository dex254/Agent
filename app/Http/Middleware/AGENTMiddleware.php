<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AGENTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in using default guard
        if (Auth::guard('agent')->check()) {
            $agent = Auth::guard('agent')->user();
            // pass the user to the request if you like
            $request->merge(['agent' => $agent]);
            return $next($request);
        }
         return redirect()->route('agent')->with('error', 'Unauthorized access.');

    }
}
