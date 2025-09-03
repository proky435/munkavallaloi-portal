<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $roles = Role::withCount('users')->paginate(15);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $availablePermissions = $this->getAvailablePermissions();
        return view('admin.roles.create', compact('availablePermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string'
        ]);

        Role::create($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $availablePermissions = $this->getAvailablePermissions();
        return view('admin.roles.edit', compact('role', 'availablePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string'
        ]);

        $role->update($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete role that has users assigned to it.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    /**
     * Get available permissions for roles
     */
    private function getAvailablePermissions(): array
    {
        return [
            'manage_users' => 'Manage Users',
            'manage_roles' => 'Manage Roles',
            'manage_categories' => 'Manage Categories',
            'view_all_tickets' => 'View All Tickets',
            'manage_all_tickets' => 'Manage All Tickets',
            'view_assigned_tickets' => 'View Assigned Tickets',
            'manage_assigned_tickets' => 'Manage Assigned Tickets',
            'access_admin_dashboard' => 'Access Admin Dashboard',
            'manage_system_settings' => 'Manage System Settings',
            'manage_user_data' => 'Manage User Data',
            'manage_salary_tickets' => 'Manage Salary Tickets',
            'create_tickets' => 'Create Tickets',
            'view_own_tickets' => 'View Own Tickets',
            'update_own_profile' => 'Update Own Profile'
        ];
    }
}
