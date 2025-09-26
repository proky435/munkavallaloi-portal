<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\DataChangeType;
use App\Models\DataChangeRequest;
use App\Models\Workplace;
use Illuminate\Support\Facades\Auth;

class DataChangeController extends Controller
{
    public function index(): View
    {
        // Get available data change types
        $dataChangeTypes = DataChangeType::active()->ordered()->get();
        
        return view('data-change.index', compact('dataChangeTypes'));
    }
    
    public function show(DataChangeType $dataChangeType): View
    {
        if (!$dataChangeType->is_active) {
            abort(404);
        }
        
        // Check if form fields are configured
        if (empty($dataChangeType->form_fields)) {
            return redirect()->route('data-change.index')
                ->with('error', 'Ez az adatváltozás típus még nincs beállítva. Kérjük, vegye fel a kapcsolatot az adminisztrátorral.');
        }
        
        // Get additional data for form options
        $workplaces = Workplace::all();
        
        return view('data-change.show', compact('dataChangeType', 'workplaces'));
    }
    
    public function store(Request $request, DataChangeType $dataChangeType)
    {
        try {
            // Build validation rules from form fields
            $rules = [];
            foreach ($dataChangeType->form_fields as $field) {
                if (isset($field['validation'])) {
                    // Convert field name to use underscores instead of spaces
                    $fieldName = str_replace(' ', '_', $field['name']);
                    $rules[$fieldName] = $field['validation'];
                }
            }
            
            // Add file validation for documents
            if ($dataChangeType->required_documents && count($dataChangeType->required_documents) > 0) {
                $rules['documents'] = 'required|array';
                $rules['documents.*'] = 'file|mimes:pdf,jpg,jpeg,png|max:5120'; // 5MB max
            }
            
            $validatedData = $request->validate($rules);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Hiba történt: ' . $e->getMessage()])->withInput();
        }
        
        // Handle file uploads
        $attachments = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('data-change-documents', $filename, 'public');
                $attachments[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType()
                ];
            }
        }
        
        // Build description
        $description = $this->buildDescription($dataChangeType, $validatedData);
        
        // Create data change request
        try {
            $dataChangeRequest = DataChangeRequest::create([
                'user_id' => Auth::id(),
                'data_change_type_id' => $dataChangeType->id,
                'title' => $dataChangeType->display_name . ' - ' . auth()->user()->name,
                'description' => $description,
                'form_data' => $validatedData,
                'attachments' => $attachments,
                'status' => 'pending',
            ]);
            
            
            return redirect()->route('data-change.show-request', $dataChangeRequest)
                ->with('success', 'Adatváltozás bejelentés sikeresen elküldve!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Hiba történt az adatváltozás mentésekor: ' . $e->getMessage()])->withInput();
        }
    }
    
    public function showRequest(DataChangeRequest $dataChangeRequest): View
    {
        // Make sure user can only see their own requests
        if ($dataChangeRequest->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('data-change.show-request', compact('dataChangeRequest'));
    }
    
    public function myRequests(): View
    {
        $requests = DataChangeRequest::where('user_id', Auth::id())
            ->with('dataChangeType')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('data-change.my-requests', compact('requests'));
    }
    
    private function buildDescription(DataChangeType $dataChangeType, array $data): string
    {
        $description = "Adatváltozás típusa: " . $dataChangeType->display_name . "\n\n";
        
        foreach ($dataChangeType->form_fields as $field) {
            // Convert field name to use underscores instead of spaces
            $fieldName = str_replace(' ', '_', $field['name']);
            
            if (isset($data[$fieldName])) {
                $value = $data[$fieldName];
                
                // Handle special field types
                if ($field['type'] === 'select' && isset($field['options_source']) && $field['options_source'] === 'workplaces') {
                    $workplace = Workplace::find($value);
                    $value = $workplace ? $workplace->name . ' (' . $workplace->code . ')' : $value;
                }
                
                $description .= $field['label'] . ": " . $value . "\n";
            }
        }
        
        return $description;
    }
}
