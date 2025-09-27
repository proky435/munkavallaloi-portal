<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

// Get first user
$user = User::first();

if (!$user) {
    echo "No users found\n";
    exit;
}

echo "Testing User methods for: " . $user->name . "\n";

try {
    // Test getCurrentWorkplace method
    echo "\n🔍 Testing getCurrentWorkplace():\n";
    $currentWorkplace = $user->getCurrentWorkplace();
    echo "Current workplace: " . ($currentWorkplace ? $currentWorkplace->name : 'None') . "\n";

    // Test getAllCurrentWorkplaces method
    echo "\n🔍 Testing getAllCurrentWorkplaces():\n";
    $allCurrentWorkplaces = $user->getAllCurrentWorkplaces();
    echo "All current workplaces: " . $allCurrentWorkplaces->pluck('name')->join(', ') . "\n";

    // Test getPermanentWorkplaces method
    echo "\n🔍 Testing getPermanentWorkplaces():\n";
    $permanentWorkplaces = $user->getPermanentWorkplaces();
    echo "Permanent workplaces: " . $permanentWorkplaces->pluck('name')->join(', ') . "\n";

    // Test getNextWorkplaceTransition method
    echo "\n🔍 Testing getNextWorkplaceTransition():\n";
    $nextTransition = $user->getNextWorkplaceTransition();
    echo "Next transition: " . ($nextTransition ? $nextTransition->workplace->name : 'None') . "\n";

    echo "\n✅ All methods work correctly!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
