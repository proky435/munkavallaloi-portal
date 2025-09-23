<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\User;
use App\Notifications\NewCommentAdded;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

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

    public function downloadAttachment(Comment $comment): StreamedResponse
    {
        // Biztonsági ellenőrzés: csak a ticket tulajdonosa vagy admin töltheti le
        $user = auth()->user();
        $canDownload = $comment->ticket->user_id === $user->id || 
                      $user->is_admin || 
                      ($user->role && ($user->hasRole('super_admin') || $user->hasRole('admin')));
        
        if (!$canDownload) {
            abort(403, 'Nincs jogosultsága a fájl letöltéséhez.');
        }

        // Ellenőrizzük, hogy van-e melléklet
        if (!$comment->attachment_path) {
            abort(404, 'Melléklet nem található.');
        }

        // Ellenőrizzük, hogy a fájl létezik-e
        if (!Storage::disk('public')->exists($comment->attachment_path)) {
            abort(404, 'Fájl nem található a szerveren.');
        }

        // Letöltés
        return Storage::disk('public')->download(
            $comment->attachment_path,
            $comment->attachment_original_name ?: 'attachment'
        );
    }
}
