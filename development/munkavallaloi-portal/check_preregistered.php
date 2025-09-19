<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PreRegisteredUser;

echo "=== PRE-REGISTERED USERS ===" . PHP_EOL;

$users = PreRegisteredUser::all();

if ($users->count() > 0) {
    foreach ($users as $user) {
        echo "ID: " . $user->id . PHP_EOL;
        echo "Name: " . $user->name . PHP_EOL;
        echo "Tax Number: " . $user->tax_number . PHP_EOL;
        echo "Birth Date: " . $user->birth_date . PHP_EOL;
        echo "Email: " . $user->email . PHP_EOL;
        echo "Workplace ID: " . $user->workplace_id . PHP_EOL;
        echo "---" . PHP_EOL;
    }
} else {
    echo "No pre-registered users found!" . PHP_EOL;
}

echo PHP_EOL . "=== TESTING SEARCH ===" . PHP_EOL;

// Test with the actual data from CSV
$taxNumber = '12345678800'; // From CSV
$birthDate = '2003-10-07'; // Converted format

echo "Searching for:" . PHP_EOL;
echo "Tax Number: " . $taxNumber . PHP_EOL;
echo "Birth Date: " . $birthDate . PHP_EOL;

$found = PreRegisteredUser::where('tax_number', $taxNumber)
    ->where('birth_date', $birthDate)
    ->first();

if ($found) {
    echo "FOUND: " . $found->name . PHP_EOL;
} else {
    echo "NOT FOUND!" . PHP_EOL;
    
    // Let's check what's actually in the database
    echo PHP_EOL . "Checking similar tax numbers:" . PHP_EOL;
    $similar = PreRegisteredUser::where('tax_number', 'LIKE', '1234567%')->get();
    foreach ($similar as $user) {
        echo "Found: " . $user->tax_number . " | " . $user->birth_date . " | " . $user->name . PHP_EOL;
    }
}
