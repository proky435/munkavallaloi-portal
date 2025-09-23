<?php

namespace App\Console\Commands;

use App\Jobs\ProcessScheduledDataChanges as ProcessScheduledDataChangesJob;
use Illuminate\Console\Command;

class ProcessScheduledDataChanges extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'data-changes:process-scheduled';

    /**
     * The console command description.
     */
    protected $description = 'Process scheduled data changes and send reminders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Processing scheduled data changes...');
        
        ProcessScheduledDataChangesJob::dispatch();
        
        $this->info('Scheduled data changes processing job dispatched successfully.');
        
        return 0;
    }
}
