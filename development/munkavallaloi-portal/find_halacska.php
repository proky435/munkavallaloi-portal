<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PreRegisteredUser;

$user = PreRegisteredUser::where('name', 'halacska')->first();

if ($user) {
    echo "FOUND halacska:" . PHP_EOL;
    echo "Tax: [" . $user->tax_number . "]" . PHP_EOL;
    echo "Tax Length: " . strlen($user->tax_number) . PHP_EOL;
    echo "Tax Trimmed: [" . trim($user->tax_number) . "]" . PHP_EOL;
    echo "Birth: [" . $user->birth_date . "]" . PHP_EOL;
    
    // Test exact search
    $testTax = '12345678800';
    $testDate = '2003-10-07';
    
    echo PHP_EOL . "Testing search:" . PHP_EOL;
    echo "Looking for tax: [$testTax]" . PHP_EOL;
    echo "Looking for date: [$testDate]" . PHP_EOL;
    
    $match = PreRegisteredUser::whereRaw('TRIM(tax_number) = ?', [$testTax])
        ->whereDate('birth_date', $testDate)
        ->first();
        
    if ($match) {
        echo "SUCCESS: Found " . $match->name . PHP_EOL;
    } else {
        echo "FAILED: Not found" . PHP_EOL;
    }
} else {
    echo "halacska user not found in database" . PHP_EOL;
}
