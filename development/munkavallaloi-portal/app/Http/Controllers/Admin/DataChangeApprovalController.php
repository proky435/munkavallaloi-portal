<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DataChangeApprovalController extends Controller
{
    /**
     * Display a listing of data change requests.
     */
    public function index(Request $request): View
    {
        $query = Ticket::with(['user', 'category'])
            ->whereHas('category', function ($q) {
                $q->where('form_type', 'data_change');
            });

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Search by user name or email
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $tickets = $query->orderBy('created_at', 'desc')
                        ->paginate(15)
                        ->appends($request->query());

        return view('admin.data-change-approval.index', compact('tickets'));
    }

    /**
     * Display the specified data change request.
     */
    public function show(Ticket $ticket): View
    {
        $ticket->load(['user', 'category', 'comments.user']);
        
        // Parse the description to extract change details
        $changeDetails = $this->parseChangeDetails($ticket->message ?? '');
        
        return view('admin.data-change-approval.show', compact('ticket', 'changeDetails'));
    }

    /**
     * Approve a data change request.
     */
    public function approve(Request $request, Ticket $ticket): RedirectResponse
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
            'apply_changes' => 'boolean',
        ]);

        // Update ticket status
        $ticket->update([
            'status' => 'closed',
            'admin_notes' => $request->admin_notes,
        ]);

        // Apply changes to user if requested
        if ($request->boolean('apply_changes')) {
            $this->applyChangesToUser($ticket);
        }

        // Add comment
        $ticket->comments()->create([
            'user_id' => auth()->id(),
            'body' => 'Adatváltozás jóváhagyva. ' . ($request->admin_notes ?: ''),
        ]);

        return redirect()->route('admin.data-change-approval.index')
            ->with('success', 'Adatváltozás sikeresen jóváhagyva.');
    }

    /**
     * Reject a data change request.
     */
    public function reject(Request $request, Ticket $ticket): RedirectResponse
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        // Update ticket status
        $ticket->update([
            'status' => 'closed',
            'admin_notes' => $request->admin_notes,
        ]);

        // Add comment
        $ticket->comments()->create([
            'user_id' => auth()->id(),
            'body' => 'Adatváltozás elutasítva. Indoklás: ' . $request->admin_notes,
        ]);

        return redirect()->route('admin.data-change-approval.index')
            ->with('success', 'Adatváltozás elutasítva.');
    }

    /**
     * Parse change details from ticket description.
     */
    private function parseChangeDetails(?string $description): array
    {
        $details = [];
        
        if (empty($description)) {
            return $details;
        }
        
        $lines = explode("\n", $description);
        
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                [$key, $value] = explode(':', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                if (!empty($value) && $value !== 'Nincs változás') {
                    $details[$key] = $value;
                }
            }
        }
        
        return $details;
    }

    /**
     * Apply approved changes to user model.
     */
    private function applyChangesToUser(Ticket $ticket): void
    {
        $user = $ticket->user;
        $changeDetails = $this->parseChangeDetails($ticket->message ?? '');
        
        $updates = [];
        
        // Map change fields to user model fields
        $fieldMapping = [
            'Új név' => 'name',
            'Új email cím' => 'email',
            'Új telefonszám' => 'phone',
            'Új cím' => 'street_address',
            'Új bankszámlaszám' => 'bank_account_number',
            'Új vészhelyzeti kapcsolattartó' => 'emergency_contact_name',
        ];
        
        foreach ($changeDetails as $changeKey => $newValue) {
            if (isset($fieldMapping[$changeKey])) {
                $field = $fieldMapping[$changeKey];
                $updates[$field] = $newValue;
            }
        }
        
        if (!empty($updates)) {
            $user->update($updates);
        }
    }
}
