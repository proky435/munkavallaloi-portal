<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PreRegisteredUser;

echo "=== EXACT DEBUG ===" . PHP_EOL;

$users = PreRegisteredUser::all();
foreach ($users as $user) {
    echo "ID: " . $user->id . PHP_EOL;
    echo "Name: '" . $user->name . "'" . PHP_EOL;
    echo "Tax Number: '" . $user->tax_number . "'" . PHP_EOL;
    echo "Birth Date: '" . $user->birth_date . "'" . PHP_EOL;
    echo "Tax Number Length: " . strlen($user->tax_number) . PHP_EOL;
    echo "Tax Number Trimmed: '" . trim($user->tax_number) . "'" . PHP_EOL;
    echo "---" . PHP_EOL;
}

// Test exact search with halacska data
echo PHP_EOL . "=== TESTING HALACSKA ===" . PHP_EOL;
$searchTax = '12345678800';
$searchDate = '2003-10-07';

echo "Searching for tax: '" . $searchTax . "'" . PHP_EOL;
echo "Searching for date: '" . $searchDate . "'" . PHP_EOL;

$found = PreRegisteredUser::whereRaw('TRIM(tax_number) = ?', [$searchTax])
    ->whereDate('birth_date', $searchDate)
    ->first();

if ($found) {
    echo "FOUND: " . $found->name . PHP_EOL;
} else {
    echo "NOT FOUND" . PHP_EOL;
    
    // Try with trim
    $foundTrimmed = PreRegisteredUser::whereRaw('TRIM(tax_number) = ?', [$searchTax])
        ->whereDate('birth_date', $searchDate)
        ->first();
        
    if ($foundTrimmed) {
        echo "FOUND WITH TRIM: " . $foundTrimmed->name . PHP_EOL;
    } else {
        echo "STILL NOT FOUND WITH TRIM" . PHP_EOL;
    }
}
