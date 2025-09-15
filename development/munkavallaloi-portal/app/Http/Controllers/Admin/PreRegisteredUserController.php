<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreRegisteredUser;
use App\Models\User;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PreRegisteredUserController extends Controller
{
    /**
     * Display a listing of pre-registered users.
     */
    public function index(): View
    {
        $preRegisteredUsers = PreRegisteredUser::with('workplace')->paginate(20);
        
        return view('admin.pre-registered-users.index', compact('preRegisteredUsers'));
    }

    /**
     * Download CSV template for bulk import.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="user_import_template.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // CSV header with semicolon delimiter
            fputcsv($file, [
                'name',
                'tax_number',
                'birth_date',
                'bank_account_number',
                'workplace_name'
            ], ';');
            
            // Example row with semicolon delimiter and Hungarian date format
            fputcsv($file, [
                'Példa Felhasználó',
                '12345678901',
                '1990.01.15',  // Hungarian date format
                '12345678-12345678-12345678',
                'Brema'
            ], ';');
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Store/Import users from CSV file.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map(function($line) {
            return str_getcsv($line, ';');
        }, file($path));
        
        // Remove header row
        $header = array_shift($data);
        
        $imported = 0;
        $errors = [];
        
        foreach ($data as $index => $row) {
            $rowNumber = $index + 2; // +2 because we removed header and arrays are 0-indexed
            
            if (count($row) < 5) {
                $errors[] = "Sor {$rowNumber}: Hiányos adatok";
                continue;
            }
            
            $userData = [
                'name' => $row[0] ?? '',
                'tax_number' => $row[1] ?? '',
                'birth_date' => $row[2] ?? '',
                'bank_account_number' => $row[3] ?? '',
                'workplace_name' => $row[4] ?? '',
            ];
            
            // Validate required fields
            $validator = Validator::make($userData, [
                'name' => 'required|string|max:255',
                'tax_number' => 'required|string|max:255|unique:pre_registered_users,tax_number|unique:users,tax_number',
                'birth_date' => 'required|date_format:Y.m.d',
                'bank_account_number' => 'required|string|max:255',
                'workplace_name' => 'required|string',
            ]);
            
            if ($validator->fails()) {
                $errors[] = "Sor {$rowNumber}: " . implode(', ', $validator->errors()->all());
                continue;
            }
            
            // Find workplace
            $workplace = Workplace::where('name', $userData['workplace_name'])->first();
            if (!$workplace) {
                $errors[] = "Sor {$rowNumber}: Munkahely '{$userData['workplace_name']}' nem található";
                continue;
            }
            
            // Create pre-registered user
            try {
                PreRegisteredUser::create([
                    'name' => $userData['name'],
                    'email' => strtolower(str_replace(' ', '.', $userData['name'])) . '@temp.local',
                    'workplace_id' => $workplace->id,
                    'phone' => null,
                    'birth_date' => date('Y-m-d', strtotime(str_replace('.', '-', $userData['birth_date']))),
                    'birth_place' => null,
                    'street_address' => null,
                    'city' => null,
                    'postal_code' => null,
                    'country' => null,
                    'bank_account_number' => $userData['bank_account_number'],
                    'tax_number' => $userData['tax_number'],
                    'social_security_number' => null,
                    'emergency_contact_name' => null,
                    'emergency_contact_phone' => null,
                    'registration_token' => Str::random(32),
                ]);
                
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Sor {$rowNumber}: Hiba történt a mentés során - " . $e->getMessage();
            }
        }
        
        $message = "{$imported} felhasználó sikeresen importálva.";
        if (!empty($errors)) {
            $message .= " Hibák: " . implode('; ', $errors);
        }
        
        return redirect()->route('admin.pre-registered-users.index')
            ->with($imported > 0 ? 'success' : 'error', $message);
    }

    /**
     * Remove the specified pre-registered user.
     */
    public function destroy(PreRegisteredUser $preRegisteredUser): RedirectResponse
    {
        $preRegisteredUser->delete();
        
        return redirect()->route('admin.pre-registered-users.index')
            ->with('success', 'Előregisztrált felhasználó törölve.');
    }
}
