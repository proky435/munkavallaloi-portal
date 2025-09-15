<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::with(['role', 'workplace']);

        // Filter by role
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        // Filter by workplace (both old enum and new workplace_id)
        if ($request->filled('workplace')) {
            $query->where('workplace', $request->workplace);
        }
        
        if ($request->filled('workplace_id')) {
            $query->where('workplace_id', $request->workplace_id);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(15)->appends($request->query());
        $roles = Role::all();
        $workplaces = Workplace::all();

        return view('admin.users.index', compact('users', 'roles', 'workplaces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all();
        $categories = Category::all();
        return view('admin.users.create', compact('roles', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'workplace' => 'required|in:Brema,Boden,Tarragona',
            'role_id' => 'nullable|exists:roles,id',
            'is_admin' => 'boolean',
            'accessible_categories' => 'nullable|array',
            'accessible_categories.*' => 'exists:categories,id'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        $categories = Category::all();
        return view('admin.users.edit', compact('user', 'roles', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'workplace' => 'required|in:Brema,Boden,Tarragona',
            'role_id' => 'nullable|exists:roles,id',
            'is_admin' => 'boolean',
            'accessible_categories' => 'nullable|array',
            'accessible_categories.*' => 'exists:categories,id'
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->tickets()->count() > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete user that has tickets.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
