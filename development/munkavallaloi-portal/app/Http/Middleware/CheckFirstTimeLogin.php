<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\CompleteProfileController;

class CheckFirstTimeLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->is_first_login) {
            $user = auth()->user();
            
            // If user has set password but profile is incomplete, go to complete-profile
            if ($user->password && !CompleteProfileController::isProfileComplete($user)) {
                // Skip redirect if already on complete-profile or first-time-login routes
                $excludedRoutes = [
                    'complete-profile.show',
                    'complete-profile.store', 
                    'first-time-login.show',
                    'first-time-login.store',
                    'logout'
                ];
                
                if (!in_array($request->route()->getName(), $excludedRoutes)) {
                    return redirect()->route('complete-profile.show');
                }
            } else {
                // If no password set yet, go to first-time-login
                if (!$user->password) {
                    return redirect()->route('first-time-login.show');
                }
            }
        }

        return $next($request);
    }
}
