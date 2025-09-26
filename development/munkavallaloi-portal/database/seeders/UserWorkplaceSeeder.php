<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserWorkplace;
use Carbon\Carbon;

class UserWorkplaceSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Migrate existing workplace assignments to the new system
        $users = User::whereNotNull('workplace_id')->get();
        
        foreach ($users as $user) {
            // Check if user already has workplace assignments
            $existingAssignment = UserWorkplace::where('user_id', $user->id)->first();
            
            if (!$existingAssignment) {
                // Create current workplace assignment
                UserWorkplace::create([
                    'user_id' => $user->id,
                    'workplace_id' => $user->workplace_id,
                    'is_primary' => true,
                    'start_date' => Carbon::now()->subMonths(6), // Assume they started 6 months ago
                    'end_date' => null, // Current assignment has no end date
                    'is_active' => true,
                    'notes' => 'Migrated from old workplace system'
                ]);
            }
        }
        
        // Create some example future transitions
        $this->createExampleTransitions();
    }
    
    private function createExampleTransitions()
    {
        // Example: User ID 1 transitions from current workplace to another
        $user = User::first();
        if ($user && $user->workplace_id) {
            // Find a different workplace
            $newWorkplace = \App\Models\Workplace::where('id', '!=', $user->workplace_id)->first();
            
            if ($newWorkplace) {
                // End current assignment on July 9th
                $currentAssignment = UserWorkplace::where('user_id', $user->id)
                    ->whereNull('end_date')
                    ->first();
                    
                if ($currentAssignment) {
                    $currentAssignment->update([
                        'end_date' => Carbon::create(2024, 7, 9)
                    ]);
                }
                
                // Create future assignment starting July 10th
                UserWorkplace::create([
                    'user_id' => $user->id,
                    'workplace_id' => $newWorkplace->id,
                    'is_primary' => true,
                    'start_date' => Carbon::create(2024, 7, 10),
                    'end_date' => null,
                    'is_active' => true,
                    'notes' => 'Scheduled workplace transition - Example'
                ]);
            }
        }
    }
}
