<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\NewTicketCreated;
use Illuminate\Support\Facades\Notification;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())->latest()->get();

    return view('tickets.index', [
        'tickets' => $tickets,
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tickets.create');
    }


    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'attachment' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
    ]);

    if ($request->hasFile('attachment')) {
        $path = $request->file('attachment')->store('attachments', 'private');
        $validated['attachment'] = $path;
    }

    $ticket = $request->user()->tickets()->create($validated);

    // ÚJ: Értesítés küldése
    $admins = User::where('is_admin', true)->get();
    Notification::send($admins, new NewTicketCreated($ticket));

    return redirect(route('tickets.index'))->with('success', 'Bejelentés sikeresen elküldve!');
}

 /**
     * Display the specified resource.
*/
public function show(Ticket $ticket): View
{
    // Biztonsági ellenőrzés: A felhasználó csak a saját bejelentését nézheti meg.
    if ($ticket->user_id !== auth()->id()) {
        abort(403);
    }

    return view('tickets.show', [
        'ticket' => $ticket,
    ]);
}


   


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
 * Download the attachment for the specified ticket.
 */
public function download(Ticket $ticket)
{
    // Biztonsági ellenőrzés: csak a saját bejelentésének csatolmányát töltheti le
    if (auth()->id() !== $ticket->user_id) {
        abort(403);
    }

    return Storage::disk('private')->download($ticket->attachment);
}




}
