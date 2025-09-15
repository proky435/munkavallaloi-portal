<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DataChangeController extends Controller
{
    /**
     * Display the data change request form.
     */
    public function index(): View
    {
        return view('data-change.index');
    }

    /**
     * Store a new data change request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'change_type' => 'required|string|in:personal,contact,financial,emergency',
            'current_name' => 'nullable|string|max:255',
            'new_name' => 'nullable|string|max:255',
            'current_phone' => 'nullable|string|max:20',
            'new_phone' => 'nullable|string|max:20',
            'current_birth_date' => 'nullable|date',
            'new_birth_date' => 'nullable|date',
            'current_birth_place' => 'nullable|string|max:255',
            'new_birth_place' => 'nullable|string|max:255',
            'current_street_address' => 'nullable|string|max:255',
            'new_street_address' => 'nullable|string|max:255',
            'current_city' => 'nullable|string|max:255',
            'new_city' => 'nullable|string|max:255',
            'current_postal_code' => 'nullable|string|max:10',
            'new_postal_code' => 'nullable|string|max:10',
            'current_country' => 'nullable|string|max:255',
            'new_country' => 'nullable|string|max:255',
            'current_bank_account' => 'nullable|string|max:255',
            'new_bank_account' => 'nullable|string|max:255',
            'current_tax_number' => 'nullable|string|max:255',
            'new_tax_number' => 'nullable|string|max:255',
            'current_social_security' => 'nullable|string|max:255',
            'new_social_security' => 'nullable|string|max:255',
            'current_emergency_name' => 'nullable|string|max:255',
            'new_emergency_name' => 'nullable|string|max:255',
            'current_emergency_phone' => 'nullable|string|max:20',
            'new_emergency_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        // Find the data change category
        $category = Category::where('form_type', 'data_change')->first();
        if (!$category) {
            return back()->with('error', __('Data change category not found. Please contact administrator.'));
        }

        // Build description with change details
        $description = $this->buildChangeDescription($request);

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('data-change-attachments', $filename, 'public');
        }

        // Create ticket
        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'category_id' => $category->id,
            'subject' => __('Data Change Request') . ' - ' . ucfirst($request->change_type),
            'message' => $description,
            'priority' => 'medium',
            'status' => 'open',
            'attachment_path' => $attachmentPath,
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', __('Data change request submitted successfully. You will be notified when it is processed.'));
    }

    /**
     * Build a detailed description of the requested changes.
     */
    private function buildChangeDescription(Request $request): string
    {
        $description = __('Data Change Request') . "\n\n";
        $description .= __('Change Type') . ': ' . ucfirst($request->change_type) . "\n\n";

        $changes = [];

        // Personal data changes
        if ($request->current_name || $request->new_name) {
            $changes[] = __('Name') . ': "' . ($request->current_name ?? __('Not set')) . '" → "' . ($request->new_name ?? __('Not set')) . '"';
        }

        if ($request->current_phone || $request->new_phone) {
            $changes[] = __('Phone') . ': "' . ($request->current_phone ?? __('Not set')) . '" → "' . ($request->new_phone ?? __('Not set')) . '"';
        }

        if ($request->current_birth_date || $request->new_birth_date) {
            $changes[] = __('Birth Date') . ': "' . ($request->current_birth_date ?? __('Not set')) . '" → "' . ($request->new_birth_date ?? __('Not set')) . '"';
        }

        if ($request->current_birth_place || $request->new_birth_place) {
            $changes[] = __('Birth Place') . ': "' . ($request->current_birth_place ?? __('Not set')) . '" → "' . ($request->new_birth_place ?? __('Not set')) . '"';
        }

        // Address changes
        if ($request->current_street_address || $request->new_street_address) {
            $changes[] = __('Street Address') . ': "' . ($request->current_street_address ?? __('Not set')) . '" → "' . ($request->new_street_address ?? __('Not set')) . '"';
        }

        if ($request->current_city || $request->new_city) {
            $changes[] = __('City') . ': "' . ($request->current_city ?? __('Not set')) . '" → "' . ($request->new_city ?? __('Not set')) . '"';
        }

        if ($request->current_postal_code || $request->new_postal_code) {
            $changes[] = __('Postal Code') . ': "' . ($request->current_postal_code ?? __('Not set')) . '" → "' . ($request->new_postal_code ?? __('Not set')) . '"';
        }

        if ($request->current_country || $request->new_country) {
            $changes[] = __('Country') . ': "' . ($request->current_country ?? __('Not set')) . '" → "' . ($request->new_country ?? __('Not set')) . '"';
        }

        // Financial data changes
        if ($request->current_bank_account || $request->new_bank_account) {
            $changes[] = __('Bank Account') . ': "' . ($request->current_bank_account ?? __('Not set')) . '" → "' . ($request->new_bank_account ?? __('Not set')) . '"';
        }

        if ($request->current_tax_number || $request->new_tax_number) {
            $changes[] = __('Tax Number') . ': "' . ($request->current_tax_number ?? __('Not set')) . '" → "' . ($request->new_tax_number ?? __('Not set')) . '"';
        }

        if ($request->current_social_security || $request->new_social_security) {
            $changes[] = __('Social Security Number') . ': "' . ($request->current_social_security ?? __('Not set')) . '" → "' . ($request->new_social_security ?? __('Not set')) . '"';
        }

        // Emergency contact changes
        if ($request->current_emergency_name || $request->new_emergency_name) {
            $changes[] = __('Emergency Contact Name') . ': "' . ($request->current_emergency_name ?? __('Not set')) . '" → "' . ($request->new_emergency_name ?? __('Not set')) . '"';
        }

        if ($request->current_emergency_phone || $request->new_emergency_phone) {
            $changes[] = __('Emergency Contact Phone') . ': "' . ($request->current_emergency_phone ?? __('Not set')) . '" → "' . ($request->new_emergency_phone ?? __('Not set')) . '"';
        }

        if (!empty($changes)) {
            $description .= __('Requested Changes') . ":\n";
            foreach ($changes as $change) {
                $description .= "• " . $change . "\n";
            }
        }

        if ($request->notes) {
            $description .= "\n" . __('Additional Notes') . ":\n" . $request->notes;
        }

        return $description;
    }
}
