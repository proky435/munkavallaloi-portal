<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $query = Ticket::with(['user', 'category']);

        // Category-based access control
        $user = auth()->user();
        if ($user->accessible_categories) {
            // User has restricted access - only show tickets from accessible categories
            $query->whereIn('category_id', $user->accessible_categories);
        }
        // If user has no accessible_categories set, they can see all (super admin)

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $tickets = $query->latest()->paginate(15)->appends($request->query());

        $stats = [
            'new_tickets' => Ticket::where('status', 'Új')->count(),
            'in_progress_tickets' => Ticket::where('status', 'Folyamatban')->count(),
            'total_users' => User::count(),
        ];

        $categories = Category::all();
        $users = User::all();

        return view('admin.dashboard', [
            'tickets' => $tickets,
            'stats' => $stats,
            'categories' => $categories,
            'users' => $users,
        ]);
    }
}