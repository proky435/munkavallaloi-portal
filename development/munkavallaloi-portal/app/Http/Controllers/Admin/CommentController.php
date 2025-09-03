<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Notifications\NewCommentAdded;

class CommentController extends Controller
{
    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

       $comment = $ticket->comments()->create([ // Létrehozott komment elmentése változóba
        'user_id' => auth()->id(),
        'body' => $validated['body'],
    ]);

        // ÉRTESÍTÉS KÜLDÉSE A FELHASZNÁLÓNAK
    $ticket->user->notify(new NewCommentAdded($comment));

    return back()->with('success', 'Válasz sikeresen elküldve!');

    }
}