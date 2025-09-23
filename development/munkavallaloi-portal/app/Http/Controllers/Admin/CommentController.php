<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Notifications\NewCommentAdded;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,txt|max:10240', // 10MB max
        ]);

        $commentData = [
            'user_id' => auth()->id(),
            'body' => $validated['body'],
        ];

        // Handle file attachment
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('comments/attachments', $filename, 'public');
            
            $commentData['attachment_path'] = $path;
            $commentData['attachment_original_name'] = $file->getClientOriginalName();
            $commentData['attachment_size'] = $file->getSize();
        }

        $comment = $ticket->comments()->create($commentData);

        // ÉRTESÍTÉS KÜLDÉSE A FELHASZNÁLÓNAK
        $ticket->user->notify(new NewCommentAdded($comment));

        return back()->with('success', 'Válasz sikeresen elküldve!');
    }
}