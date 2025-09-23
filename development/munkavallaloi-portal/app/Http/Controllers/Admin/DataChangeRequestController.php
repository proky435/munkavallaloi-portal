<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataChangeRequest;
use App\Models\DataChangeType;
use App\Services\DataChangeProcessor;
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
            'status' => 'required|in:pending,approved,rejected,processing,revision_required,completed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);
        
        $dataChangeRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'processed_by' => Auth::id(),
            'processed_at' => now()
        ]);
        
        return redirect()->route('admin.data-change-requests.show', $dataChangeRequest)
            ->with('success', 'Adatváltozás kérés státusza sikeresen frissítve!');
    }
    
    public function apply(Request $request, DataChangeRequest $dataChangeRequest)
    {
        try {
            $processor = new DataChangeProcessor();
            
            // Check if this should be scheduled
            $scheduledFor = $request->input('scheduled_for');
            
            if ($scheduledFor) {
                // Schedule for later
                $dataChangeRequest->update([
                    'scheduled_for' => $scheduledFor,
                    'is_scheduled' => true,
                    'admin_notes' => ($dataChangeRequest->admin_notes ?? '') . "\n\nÜtemezve alkalmazásra: " . $scheduledFor
                ]);
                
                // Send approval notification with scheduling info
                $dataChangeRequest->user->notify(new \App\Notifications\DataChangeApprovedNotification($dataChangeRequest));
                
                return redirect()->back()->with('success', 'Adatváltozás ütemezve: ' . \Carbon\Carbon::parse($scheduledFor)->format('Y.m.d H:i') . '-ra. A felhasználó értesítést kapott.');
            } else {
                // Apply immediately
                $result = $processor->processApprovedRequest($dataChangeRequest);
                
                if ($result['success']) {
                    // Send immediate approval notification
                    $dataChangeRequest->user->notify(new \App\Notifications\DataChangeApprovedNotification($dataChangeRequest));
                    
                    return redirect()->back()->with('success', 'Adatok sikeresen alkalmazva! ' . count($result['changes']) . ' változás került alkalmazásra.');
                } else {
                    return redirect()->back()->with('error', 'Hiba történt az adatok alkalmazása során. Hibák: ' . implode(', ', array_column($result['errors'], 'error')));
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hiba történt: ' . $e->getMessage());
        }
    }
}
