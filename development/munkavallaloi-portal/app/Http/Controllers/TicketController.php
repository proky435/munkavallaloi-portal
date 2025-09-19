<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\NewTicketCreated;
use App\Notifications\CategoryTicketCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())->with('category')->latest()->paginate(10);

    return view('tickets.index', [
        'tickets' => $tickets,
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // All users can see all categories when creating tickets
        $categories = \App\Models\Category::all();
        return view('tickets.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Basic validation
        $basicValidation = $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        // Get the category and its form fields
        $category = Category::with('formFields')->findOrFail($request->category_id);
        
        // Build dynamic validation rules
        $dynamicRules = [];
        $formData = [];
        
        foreach ($category->formFields as $field) {
            $fieldKey = "form_data.{$field->id}";
            $rules = [];
            
            // Add required rule if field is required
            if ($field->pivot->is_required) {
                $rules[] = 'required';
            } else {
                $rules[] = 'nullable';
            }
            
            // Add field type specific validation rules
            switch ($field->type) {
                case 'text':
                case 'textarea':
                    $rules[] = 'string';
                    if (isset($field->validation_rules['max'])) {
                        $rules[] = 'max:' . $field->validation_rules['max'];
                    }
                    break;
                    
                case 'email':
                    $rules[] = 'email';
                    $rules[] = 'max:255';
                    break;
                    
                case 'tel':
                    $rules[] = 'string';
                    $rules[] = 'max:20';
                    break;
                    
                case 'number':
                case 'currency':
                    $rules[] = 'numeric';
                    if (isset($field->validation_rules['min'])) {
                        $rules[] = 'min:' . $field->validation_rules['min'];
                    }
                    break;
                    
                case 'date':
                    $rules[] = 'date';
                    break;
                    
                case 'file':
                    $rules[] = 'file';
                    if (isset($field->validation_rules['mimes'])) {
                        $rules[] = 'mimes:' . $field->validation_rules['mimes'];
                    }
                    if (isset($field->validation_rules['max'])) {
                        $rules[] = 'max:' . $field->validation_rules['max'];
                    }
                    break;
                    
                case 'checkbox':
                    $rules[] = 'boolean';
                    break;
                    
                case 'select':
                    $rules[] = 'string';
                    if ($field->pivot->field_options) {
                        $options = json_decode($field->pivot->field_options, true);
                        if ($options) {
                            $rules[] = 'in:' . implode(',', $options);
                        }
                    }
                    break;
            }
            
            $dynamicRules[$fieldKey] = $rules;
        }

        // Validate the dynamic form data
        $validator = Validator::make($request->all(), $dynamicRules);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Process form data and handle file uploads
        $processedFormData = [];
        
        if ($request->has('form_data')) {
            foreach ($request->form_data as $fieldId => $value) {
                $field = $category->formFields->where('id', $fieldId)->first();
                
                if ($field && $field->type === 'file' && $request->hasFile("form_data.{$fieldId}")) {
                    // Handle file upload
                    $file = $request->file("form_data.{$fieldId}");
                    $path = $file->store('dynamic_form_attachments', 'private');
                    $processedFormData[$fieldId] = [
                        'type' => 'file',
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'label' => $field->pivot->label
                    ];
                } else {
                    // Handle regular form data
                    $processedFormData[$fieldId] = [
                        'type' => $field->type ?? 'text',
                        'value' => $value,
                        'label' => $field->pivot->label ?? 'Unknown Field'
                    ];
                }
            }
        }

        // Create the ticket with dynamic form data
        $ticket = $request->user()->tickets()->create([
            'category_id' => $request->category_id,
            'subject' => $category->name . ' - Bejelentés',
            'message' => 'Dinamikus űrlap alapján létrehozott bejelentés',
            'form_data' => $processedFormData,
        ]);

        // Send notifications
        $admins = User::where('is_admin', true)->get();
        Notification::send($admins, new NewTicketCreated($ticket));

        if ($ticket->category && $ticket->category->responsible_email) {
            Notification::route('mail', $ticket->category->responsible_email)
                ->notify(new CategoryTicketCreated($ticket));
        }

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

    // Load comments with user relationship
    $ticket->load(['comments.user', 'user', 'category']);

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
