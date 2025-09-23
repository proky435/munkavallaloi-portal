<?php

namespace App\Jobs;

use App\Models\DataChangeRequest;
use App\Services\DataChangeProcessor;
use App\Notifications\DataChangeAppliedNotification;
use App\Notifications\DataChangeReminderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProcessScheduledDataChanges implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = Carbon::now();
        
        // 1. Process data changes that are due today
        $this->processScheduledChanges($now);
        
        // 2. Send reminder emails for changes due tomorrow
        $this->sendReminders($now);
    }
    
    private function processScheduledChanges(Carbon $now): void
    {
        $dueChanges = DataChangeRequest::where('status', 'approved')
            ->where('is_scheduled', true)
            ->whereDate('scheduled_for', '<=', $now->toDateString())
            ->whereTime('scheduled_for', '<=', $now->toTimeString())
            ->get();
            
        foreach ($dueChanges as $request) {
            try {
                $processor = new DataChangeProcessor();
                $result = $processor->processApprovedRequest($request);
                
                if ($result['success']) {
                    // Update status to completed
                    $request->update([
                        'status' => 'completed',
                        'processed_at' => $now,
                        'admin_notes' => ($request->admin_notes ?? '') . "\n\nAutomatikusan alkalmazva: " . $now->format('Y-m-d H:i:s')
                    ]);
                    
                    // Send notification to user
                    $request->user->notify(new DataChangeAppliedNotification($request));
                    
                    Log::info('Scheduled data change applied successfully', [
                        'request_id' => $request->id,
                        'user_id' => $request->user_id,
                        'scheduled_for' => $request->scheduled_for,
                        'changes' => count($result['changes'])
                    ]);
                } else {
                    Log::error('Failed to apply scheduled data change', [
                        'request_id' => $request->id,
                        'errors' => $result['errors']
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Exception while processing scheduled data change', [
                    'request_id' => $request->id,
                    'exception' => $e->getMessage()
                ]);
            }
        }
    }
    
    private function sendReminders(Carbon $now): void
    {
        $tomorrow = $now->copy()->addDay();
        
        $reminderDue = DataChangeRequest::where('status', 'approved')
            ->where('is_scheduled', true)
            ->whereDate('scheduled_for', $tomorrow->toDateString())
            ->whereNull('reminder_sent_at')
            ->get();
            
        foreach ($reminderDue as $request) {
            try {
                $request->user->notify(new DataChangeReminderNotification($request));
                
                $request->update(['reminder_sent_at' => $now]);
                
                Log::info('Reminder sent for scheduled data change', [
                    'request_id' => $request->id,
                    'user_id' => $request->user_id,
                    'scheduled_for' => $request->scheduled_for
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send reminder', [
                    'request_id' => $request->id,
                    'exception' => $e->getMessage()
                ]);
            }
        }
    }
}
