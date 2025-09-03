<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User; // Új import
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // JAVÍTVA: a ->get() cseréje ->paginate(15)-re
    $tickets = Ticket::with('user')->latest()->paginate(15);

    $stats = [
        'new_tickets' => Ticket::where('status', 'Új')->count(),
        'in_progress_tickets' => Ticket::where('status', 'Folyamatban')->count(),
        'total_users' => User::count(),
    ];

    return view('admin.dashboard', [
        'tickets' => $tickets,
        'stats' => $stats,
    ]);
    }
}