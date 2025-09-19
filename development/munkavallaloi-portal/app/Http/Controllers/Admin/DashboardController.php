<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $query = Ticket::with(['user', 'category']);

        // Category-based access control for admin management
        $user = auth()->user();
        $manageableCategories = $user->getManageableCategories();
        if ($manageableCategories->isNotEmpty() && !$user->hasPermission('manage_all_tickets') && !($user->is_admin && empty($user->accessible_categories))) {
            $query->whereIn('category_id', $manageableCategories->pluck('id'));
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by workplace
        if ($request->filled('workplace_id')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('workplace_id', $request->workplace_id);
            });
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

        $categories = $user->getManageableCategories();
        $users = User::all();
        $workplaces = Workplace::all();

        return view('admin.dashboard', [
            'tickets' => $tickets,
            'stats' => $stats,
            'categories' => $categories,
            'users' => $users,
            'workplaces' => $workplaces,
        ]);
    }
}