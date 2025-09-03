<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TicketController;

class TicketController extends Controller
{
    public function show(Ticket $ticket): View
    {
        // Category-based access control
        $user = auth()->user();
        if ($user->accessible_categories && !$user->canAccessCategory($ticket->category_id)) {
            abort(403, 'Nincs jogosultságod ehhez a bejelentéshez.');
        }

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
