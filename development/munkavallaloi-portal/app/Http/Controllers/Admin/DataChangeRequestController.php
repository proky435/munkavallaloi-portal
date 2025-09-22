<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataChangeRequest;
use App\Models\DataChangeType;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DataChangeRequestController extends Controller
{
    public function index(): View
    {
        $requests = DataChangeRequest::with(['user', 'dataChangeType', 'processedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.data-change-requests.index', compact('requests'));
    }
    
    public function show(DataChangeRequest $dataChangeRequest): View
    {
        $dataChangeRequest->load(['user', 'dataChangeType', 'processedBy']);
        
        return view('admin.data-change-requests.show', compact('dataChangeRequest'));
    }
    
    public function update(Request $request, DataChangeRequest $dataChangeRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,processing',
            'admin_notes' => 'nullable|string|max:1000'
        ]);
        
        $dataChangeRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'processed_by' => Auth::id(),
            'processed_at' => now()
        ]);
        
        return redirect()->route('admin.data-change-requests.show', $dataChangeRequest)
            ->with('success', 'Adatváltozás kérés státusza frissítve!');
    }
}
