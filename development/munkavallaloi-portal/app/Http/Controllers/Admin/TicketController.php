<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        
        // Build query with category-based access control
        $query = Ticket::with(['user', 'category']);
        
        // Apply category-based access control
        if ($user->accessible_categories) {
            $accessibleCategoryIds = json_decode($user->accessible_categories, true);
            $query->whereIn('category_id', $accessibleCategoryIds);
        }
        
        // Apply filters
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        // Get categories for filter dropdown (respecting access control)
        $categories = Category::query();
        if ($user->accessible_categories) {
            $accessibleCategoryIds = json_decode($user->accessible_categories, true);
            $categories->whereIn('id', $accessibleCategoryIds);
        }
        $categories = $categories->get();
        
        // Order by creation date (newest first) and paginate
        $tickets = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.tickets.index', [
            'tickets' => $tickets,
            'categories' => $categories,
        ]);
    }

    public function show(Ticket $ticket): View
    {
        // Category-based access control
        $user = auth()->user();
        if ($user->accessible_categories && !$user->canAccessCategory($ticket->category_id)) {
            abort(403, 'Nincs jogosultságod ehhez a bejelentéshez.');
        }

        // Load the ticket with all necessary relationships
        $ticket->load(['user', 'category', 'comments.user.role']);

        return view('admin.tickets.show', [
            'ticket' => $ticket,
        ]);
    }

    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        // Category-based access control
        $user = auth()->user();
        if ($user->accessible_categories && !$user->canAccessCategory($ticket->category_id)) {
            abort(403, 'Nincs jogosultságod ehhez a bejelentéshez.');
        }

        $validated = $request->validate([
            'status' => 'required|string|in:Új,Folyamatban,Lezárva',
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.tickets.show', $ticket)->with('success', 'A bejelentés státusza sikeresen frissítve!');
    }
}
