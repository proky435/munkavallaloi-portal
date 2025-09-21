<?php

namespace App\Http\Controllers;

use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CompleteProfileController extends Controller
{
    /**
     * Show the complete profile form.
     */
    public function show(): View
    {
        $user = Auth::user();
        $workplaces = Workplace::all();
        
        // Check which fields are missing
        $missingFields = $this->getMissingFields($user);
        
        return view('auth.complete-profile', compact('user', 'workplaces', 'missingFields'));
    }

    /**
     * Handle the profile completion.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Validate only the fields that are being submitted
        $rules = [];
        $messages = [];
        
        // Define validation rules for each field
        $fieldRules = [
            'phone' => 'nullable|string|max:20',
            'birth_place' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:50',
            'social_security_number' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'workplace_id' => 'nullable|exists:workplaces,id',
        ];
        
        // Only validate fields that are present in the request
        foreach ($fieldRules as $field => $rule) {
            if ($request->has($field)) {
                $rules[$field] = $rule;
            }
        }
        
        $validatedData = $request->validate($rules, $messages);
        
        // Update user with the provided data
        $user->update($validatedData);
        
        // Check if profile is now complete and update is_first_login accordingly
        if (self::isProfileComplete($user->fresh())) {
            $user->update(['is_first_login' => false]);
            return redirect()->route('dashboard')->with('success', __('Profil sikeresen kiegészítve! Üdvözöljük a rendszerben!'));
        }
        
        return redirect()->route('complete-profile.show')->with('success', __('Adatok sikeresen mentve! Kérjük, töltse ki a további hiányzó mezőket.'));
    }
    
    /**
     * Get missing fields for the user.
     */
    private function getMissingFields($user): array
    {
        $requiredFields = [
            'phone' => __('Telefonszám'),
            'birth_place' => __('Születési hely'),
            'street_address' => __('Utca, házszám'),
            'city' => __('Város'),
            'postal_code' => __('Irányítószám'),
            'country' => __('Ország'),
            'bank_account_number' => __('Bankszámlaszám'),
            'social_security_number' => __('TAJ szám'),
            'emergency_contact_name' => __('Vészhelyzeti kapcsolattartó neve'),
            'emergency_contact_phone' => __('Vészhelyzeti kapcsolattartó telefonja'),
            'workplace_id' => __('Munkahely'),
        ];
        
        $missing = [];
        
        foreach ($requiredFields as $field => $label) {
            if (empty($user->$field)) {
                $missing[$field] = $label;
            }
        }
        
        return $missing;
    }
    
    /**
     * Check if user has completed their profile.
     */
    public static function isProfileComplete($user): bool
    {
        $requiredFields = [
            'phone', 'birth_place', 'street_address', 'city', 
            'postal_code', 'country', 'bank_account_number', 
            'social_security_number', 'emergency_contact_name', 
            'emergency_contact_phone', 'workplace_id'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($user->$field)) {
                return false;
            }
        }
        
        return true;
    }
}
