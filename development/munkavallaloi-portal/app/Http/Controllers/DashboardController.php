<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Ticket;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function userDashboard()
    {
        $user = Auth::user();
        
        // Check if user has admin permissions - if so, redirect to admin dashboard
        $hasAdminAccess = $user->is_admin || 
                         $user->hasPermission('access_admin_dashboard') ||
                         $user->hasPermission('manage_all_tickets') ||
                         $user->hasPermission('view_assigned_tickets');
        
        if ($hasAdminAccess) {
            return redirect()->route('admin.dashboard');
        }
        
        // Get user's recent tickets
        $recentTickets = Ticket::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get recent articles
        $recentArticles = Article::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
            
        // Get ticket counts by status
        $ticketCounts = [
            'open' => Ticket::where('user_id', $user->id)->where('status', 'open')->count(),
            'in_progress' => Ticket::where('user_id', $user->id)->where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('user_id', $user->id)->where('status', 'resolved')->count(),
        ];
        
        return view('user-dashboard', compact('recentTickets', 'recentArticles', 'ticketCounts'));
    }

    /**
     * Redirect to admin dashboard if user has admin permissions.
     */
    public function adminDashboard()
    {
        $user = Auth::user();
        
        // Check if user has admin permissions
        $hasAdminAccess = $user->is_admin || 
                         $user->hasPermission('access_admin_dashboard') ||
                         $user->hasPermission('manage_all_tickets') ||
                         $user->hasPermission('view_assigned_tickets');
        
        if ($hasAdminAccess) {
            // Redirect to admin dashboard
            return redirect()->route('admin.dashboard');
        }
        
        // If no admin access, redirect to user dashboard
        return redirect()->route('dashboard');
    }
}
