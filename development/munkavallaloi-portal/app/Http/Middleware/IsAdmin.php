<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Check if user is admin OR has admin-level role permissions
            if ($user->is_admin || 
                $user->hasPermission('access_admin_dashboard') ||
                $user->hasPermission('manage_all_tickets') ||
                $user->hasPermission('view_assigned_tickets')) {
                return $next($request);
            }
        }

        return redirect('/');
    }
}
