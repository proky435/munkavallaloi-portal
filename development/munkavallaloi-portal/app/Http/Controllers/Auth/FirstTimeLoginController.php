<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PreRegisteredUser;
use App\Http\Controllers\CompleteProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FirstTimeLoginController extends Controller
{
    /**
     * Show the first-time login form.
     */
    public function show(): View
    {
        // Ha a felhasználó már be van jelentkezve és nem first-time login, irányítsuk át
        if (auth()->check() && !auth()->user()->is_first_login) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.first-time-login');
    }

    /**
     * Handle first-time login for pre-registered users.
     */
    public function store(Request $request): RedirectResponse
    {
        // Ha a felhasználó már be van jelentkezve és nem first-time login, irányítsuk át
        if (auth()->check() && !auth()->user()->is_first_login) {
            return redirect()->route('dashboard');
        }
        
        // Ha a felhasználó be van jelentkezve és first-time login, akkor csak frissítsük az adatait
        if (auth()->check() && auth()->user()->is_first_login) {
            $request->validate([
                'password' => ['required', 'confirmed', 'min:8'],
            ]);
            
            $user = auth()->user();
            $user->update([
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
            ]);
            
            // Check if profile is complete
            if (!CompleteProfileController::isProfileComplete($user)) {
                // Don't set is_first_login to false yet - user can still use first-time login
                return redirect()->route('complete-profile.show')->with('success', __('Jelszó sikeresen beállítva! Kérjük, egészítse ki profilját.'));
            }
            
            // Only set is_first_login to false when profile is complete
            $user->update(['is_first_login' => false]);
            return redirect()->route('dashboard')->with('success', __('Jelszó sikeresen beállítva! Üdvözöljük a rendszerben.'));
        }

        // Eredeti logika előregisztrált felhasználóknak
        $request->validate([
            'tax_number' => ['required', 'string'],
            'birth_date' => ['required', 'date_format:Y.m.d'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Find pre-registered user by tax number and birth date
        $convertedDate = date('Y-m-d', strtotime(str_replace('.', '-', $request->birth_date)));
        $preRegisteredUser = PreRegisteredUser::whereRaw('TRIM(tax_number) = ?', [trim($request->tax_number)])
            ->whereDate('birth_date', $convertedDate)
            ->first();

        if (!$preRegisteredUser) {
            return back()->withErrors([
                'tax_number' => __('Nem található előregisztrált felhasználó ezekkel az adatokkal.'),
            ])->onlyInput('tax_number', 'birth_date');
        }

        // Check if user already exists
        $existingUser = User::where('tax_number', $request->tax_number)->first();
        if ($existingUser) {
            return back()->withErrors([
                'tax_number' => __('Ez a felhasználó már aktiválva van. Használja a normál bejelentkezést.'),
            ])->onlyInput('tax_number', 'birth_date');
        }

        // Create new user from pre-registered data
        $user = User::create([
            'name' => $preRegisteredUser->name,
            'email' => $preRegisteredUser->email ?? $preRegisteredUser->tax_number . '@temp.local',
            'password' => Hash::make($request->password),
            'workplace_id' => $preRegisteredUser->workplace_id,
            'phone' => $preRegisteredUser->phone,
            'birth_date' => $preRegisteredUser->birth_date,
            'birth_place' => $preRegisteredUser->birth_place,
            'street_address' => $preRegisteredUser->street_address,
            'city' => $preRegisteredUser->city,
            'postal_code' => $preRegisteredUser->postal_code,
            'country' => $preRegisteredUser->country,
            'bank_account_number' => $preRegisteredUser->bank_account_number,
            'tax_number' => $preRegisteredUser->tax_number,
            'social_security_number' => $preRegisteredUser->social_security_number,
            'emergency_contact_name' => $preRegisteredUser->emergency_contact_name,
            'emergency_contact_phone' => $preRegisteredUser->emergency_contact_phone,
            'is_first_login' => true, // Keep as first login until profile is verified complete
            'email_verified_at' => now(),
            'role_id' => 5, // Default user role
        ]);

        // Delete pre-registered user record
        $preRegisteredUser->delete();

        // Log in the new user
        Auth::login($user);

        // Check if profile is complete, if not redirect to complete profile
        if (!CompleteProfileController::isProfileComplete($user)) {
            return redirect()->route('complete-profile.show')->with('success', __('Fiók sikeresen aktiválva! Kérjük, egészítse ki profilját.'));
        }

        return redirect()->route('dashboard')->with('success', __('Fiók sikeresen aktiválva! Üdvözöljük a rendszerben.'));
    }
}
