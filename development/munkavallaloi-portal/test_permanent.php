<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Workplace;
use App\Models\UserWorkplace;

// Get first user and workplaces
$user = User::first();
$boden = Workplace::where('name', 'Boden')->first();
$tarragona = Workplace::where('name', 'Tarragona')->first();

if (!$user || !$boden || !$tarragona) {
    echo "Missing user or workplaces\n";
    exit;
}

echo "Testing permanent workplace assignments for: " . $user->name . "\n";

// Create permanent assignments
try {
    $assignment1 = UserWorkplace::create([
        'user_id' => $user->id,
        'workplace_id' => $boden->id,
        'start_date' => null,
        'end_date' => null,
        'is_primary' => true,
        'is_active' => true,
        'notes' => 'Állandó HR munkahely'
    ]);
    echo "✅ Created permanent assignment: Boden\n";

    $assignment2 = UserWorkplace::create([
        'user_id' => $user->id,
        'workplace_id' => $tarragona->id,
        'start_date' => null,
        'end_date' => null,
        'is_primary' => false,
        'is_active' => true,
        'notes' => 'Állandó támogatói munkahely'
    ]);
    echo "✅ Created permanent assignment: Tarragona\n";

    // Test the methods
    echo "\n🔍 Testing model methods:\n";
    
    $permanentWorkplaces = $user->getPermanentWorkplaces();
    echo "Permanent workplaces: " . $permanentWorkplaces->pluck('name')->join(', ') . "\n";
    
    $allCurrentWorkplaces = $user->getAllCurrentWorkplaces();
    echo "All current workplaces: " . $allCurrentWorkplaces->pluck('name')->join(', ') . "\n";
    
    // Test status
    echo "\n📊 Assignment statuses:\n";
    foreach ($user->userWorkplaces as $assignment) {
        echo "- {$assignment->workplace->name}: {$assignment->status} " . 
             ($assignment->is_permanent ? "(permanent)" : "(temporary)") . "\n";
    }
    
    echo "\n✅ Test completed successfully!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
