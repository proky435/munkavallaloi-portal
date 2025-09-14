<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WorkplaceController extends Controller
{
    public function index(): View
    {
        $workplaces = Workplace::orderBy('name')->paginate(15);
        
        return view('admin.workplaces.index', compact('workplaces'));
    }

    public function create(): View
    {
        return view('admin.workplaces.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:workplaces',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Workplace::create($validated);

        return redirect()->route('admin.workplaces.index')
            ->with('success', 'Munkahely sikeresen létrehozva!');
    }

    public function show(Workplace $workplace): View
    {
        $workplace->load('users');
        
        return view('admin.workplaces.show', compact('workplace'));
    }

    public function edit(Workplace $workplace): View
    {
        return view('admin.workplaces.edit', compact('workplace'));
    }

    public function update(Request $request, Workplace $workplace): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:workplaces,code,' . $workplace->id,
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $workplace->update($validated);

        return redirect()->route('admin.workplaces.index')
            ->with('success', 'Munkahely sikeresen frissítve!');
    }

    public function destroy(Workplace $workplace): RedirectResponse
    {
        if ($workplace->users()->count() > 0) {
            return redirect()->route('admin.workplaces.index')
                ->with('error', 'Nem törölhető a munkahely, mert vannak hozzá rendelt dolgozók!');
        }

        $workplace->delete();

        return redirect()->route('admin.workplaces.index')
            ->with('success', 'Munkahely sikeresen törölve!');
    }
}
