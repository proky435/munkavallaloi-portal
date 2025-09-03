<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\NewCommentAdded;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        // Biztonsági ellenőrzés: A felhasználó csak a saját bejelentéséhez szólhat hozzá.
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'body' => 'required|string',
        ]);

       $comment = $ticket->comments()->create([ // Létrehozott komment elmentése változóba
        'user_id' => auth()->id(),
        'body' => $validated['body'],
    ]);

        // ÉRTESÍTÉS KÜLDÉSE AZ ADMINOKNAK
    $admins = User::where('is_admin', true)->get();
    Notification::send($admins, new NewCommentAdded($comment));

    return back()->with('success', 'Válasz sikeresen elküldve!');

    }
}
