<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Workplace;
use App\Models\UserWorkplace;
use Carbon\Carbon;

class UserWorkplaceController extends Controller
{
    public function index()
    {
        $users = User::with(['userWorkplaces.workplace'])
                    ->paginate(15);
                    
        return view('admin.user-workplaces.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['userWorkplaces.workplace']);
        $workplaces = Workplace::where('is_active', true)->get();
        
        return view('admin.user-workplaces.show', compact('user', 'workplaces'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'workplace_id' => 'required|exists:workplaces,id',
            'assignment_type' => 'required|in:permanent,temporary',
            'start_date' => 'required_if:assignment_type,temporary|nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_primary' => 'boolean',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Check if permanent assignment already exists for this workplace
        if ($request->assignment_type === 'permanent') {
            $existingPermanent = UserWorkplace::where('user_id', $user->id)
                                             ->where('workplace_id', $request->workplace_id)
                                             ->whereNull('start_date')
                                             ->whereNull('end_date')
                                             ->first();
            
            if ($existingPermanent) {
                return redirect()->back()
                    ->withErrors(['workplace_id' => 'Ez a felhasználó már állandó hozzárendeléssel rendelkezik ehhez a munkahelyhez.'])
                    ->withInput();
            }
        }

        // If this is set as primary, unset other primary assignments
        if ($request->is_primary) {
            UserWorkplace::where('user_id', $user->id)
                         ->where('is_primary', true)
                         ->update(['is_primary' => false]);
        }

        // Set dates based on assignment type
        $startDate = $request->assignment_type === 'permanent' ? null : $request->start_date;
        $endDate = $request->assignment_type === 'permanent' ? null : $request->end_date;

        UserWorkplace::create([
            'user_id' => $user->id,
            'workplace_id' => $request->workplace_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_primary' => $request->boolean('is_primary'),
            'is_active' => true,
            'notes' => $request->notes ?: ($request->assignment_type === 'permanent' ? 'Állandó munkahely hozzárendelés' : null)
        ]);

        return redirect()->route('admin.user-workplaces.show', $user)
                        ->with('success', 'Munkahely hozzárendelés sikeresen létrehozva!');
    }

    public function update(Request $request, User $user, UserWorkplace $userWorkplace)
    {
        $request->validate([
            'workplace_id' => 'required|exists:workplaces,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:1000'
        ]);

        // If this is set as primary, unset other primary assignments
        if ($request->is_primary && !$userWorkplace->is_primary) {
            UserWorkplace::where('user_id', $user->id)
                         ->where('id', '!=', $userWorkplace->id)
                         ->where('is_primary', true)
                         ->update(['is_primary' => false]);
        }

        $userWorkplace->update([
            'workplace_id' => $request->workplace_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_primary' => $request->boolean('is_primary'),
            'is_active' => $request->boolean('is_active'),
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.user-workplaces.show', $user)
                        ->with('success', 'Munkahely hozzárendelés sikeresen frissítve!');
    }

    public function destroy(User $user, UserWorkplace $userWorkplace)
    {
        $userWorkplace->delete();

        return redirect()->route('admin.user-workplaces.show', $user)
                        ->with('success', 'Munkahely hozzárendelés sikeresen törölve!');
    }

    /**
     * Create a scheduled workplace transition
     */
    public function createTransition(Request $request, User $user)
    {
        $request->validate([
            'current_workplace_id' => 'required|exists:workplaces,id',
            'new_workplace_id' => 'required|exists:workplaces,id|different:current_workplace_id',
            'transition_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:1000'
        ]);

        // End current assignment
        $currentAssignment = UserWorkplace::where('user_id', $user->id)
                                         ->where('workplace_id', $request->current_workplace_id)
                                         ->whereNull('end_date')
                                         ->first();

        if ($currentAssignment) {
            $currentAssignment->update([
                'end_date' => Carbon::parse($request->transition_date)->subDay()
            ]);
        }

        // Create new assignment
        UserWorkplace::create([
            'user_id' => $user->id,
            'workplace_id' => $request->new_workplace_id,
            'start_date' => $request->transition_date,
            'end_date' => null,
            'is_primary' => true,
            'is_active' => true,
            'notes' => $request->notes ?: 'Scheduled workplace transition'
        ]);

        return redirect()->route('admin.user-workplaces.show', $user)
                        ->with('success', 'Munkahely váltás sikeresen ütemezve!');
    }
}
