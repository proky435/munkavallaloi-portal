<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PreRegisteredUser;

// Simulate the exact controller logic
$taxNumber = '12345678800'; // From form
$birthDate = '2003.10.07'; // From form (format from frontend)

echo "=== CONTROLLER LOGIC TEST ===" . PHP_EOL;
echo "Input tax_number: " . $taxNumber . PHP_EOL;
echo "Input birth_date: " . $birthDate . PHP_EOL;

// Convert date exactly like the controller does
$convertedDate = date('Y-m-d', strtotime(str_replace('.', '-', $birthDate)));
echo "Converted date: " . $convertedDate . PHP_EOL;

// Search exactly like the controller does (FIXED VERSION)
$preRegisteredUser = PreRegisteredUser::where('tax_number', $taxNumber)
    ->whereDate('birth_date', $convertedDate)
    ->first();

if ($preRegisteredUser) {
    echo "SUCCESS: Found user: " . $preRegisteredUser->name . PHP_EOL;
} else {
    echo "FAILED: User not found!" . PHP_EOL;
    
    // Debug: show what we're looking for vs what exists
    echo PHP_EOL . "=== DEBUG INFO ===" . PHP_EOL;
    echo "Looking for tax_number: '" . $taxNumber . "'" . PHP_EOL;
    echo "Looking for birth_date: '" . $convertedDate . "'" . PHP_EOL;
    
    $allUsers = PreRegisteredUser::all();
    foreach ($allUsers as $user) {
        echo "DB has: tax='" . $user->tax_number . "' birth='" . $user->birth_date . "' name='" . $user->name . "'" . PHP_EOL;
        
        // Check exact matches
        $taxMatch = ($user->tax_number === $taxNumber) ? 'YES' : 'NO';
        $dateMatch = (substr($user->birth_date, 0, 10) === $convertedDate) ? 'YES' : 'NO';
        echo "  Tax match: $taxMatch, Date match: $dateMatch" . PHP_EOL;
    }
}
