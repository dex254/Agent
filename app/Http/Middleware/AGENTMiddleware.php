<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AGENTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
 public function handle(Request $request, Closure $next)
    {
        // ✅ 1. Check if the user is authenticated using the agent guard
        if (!Auth::guard('agent')->check()) {
            return redirect()->route('agent')
                ->with('error', 'Unauthorized access. Please log in.');
        }

        // ✅ 2. Retrieve the authenticated agent
        $agent = Auth::guard('agent')->user();

        // ✅ 3. Check account status (inactive or suspended)
        if (strtolower($agent->status) !== 'pending') {
            Auth::guard('agent')->logout();

            // Invalidate session for safety
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('agent')
                ->with('error', 'Your account is not active. Please contact support.');
        }

        // ✅ 4. Regenerate session every 10 minutes to prevent fixation
        $lastRegen = session('last_regeneration');
        if (!$lastRegen || Carbon::parse($lastRegen)->diffInMinutes(now()) >= 10) {
            $request->session()->regenerate();
            session(['last_regeneration' => now()]);
        }

        // ✅ 5. Session timeout after 30 minutes of inactivity
        if (session()->has('last_activity')) {
            if (Carbon::parse(session('last_activity'))->diffInMinutes(now()) > 30) {
                Auth::guard('agent')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('agent')
                    ->with('error', 'Session expired due to inactivity. Please log in again.');
            }
        }

        // Update activity time
        session(['last_activity' => now()]);

        // ✅ 6. Merge agent info for downstream controllers
        $request->merge(['agent' => $agent]);

        // ✅ 7. Continue request
        return $next($request);
    }
}
