<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\CompleteProfileController;

class CheckProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip check if user is not authenticated
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // Skip check for certain routes
        $excludedRoutes = [
            'complete-profile.show',
            'complete-profile.store',
            'first-time-login.show',
            'first-time-login.store',
            'logout',
            'profile.edit',
            'profile.update',
        ];

        if (in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }

        // Check if profile is complete
        if (!CompleteProfileController::isProfileComplete($user)) {
            return redirect()->route('complete-profile.show')
                ->with('info', __('Kérjük, egészítse ki profilját a folytatáshoz.'));
        }

        return $next($request);
    }
}
