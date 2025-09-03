<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'Full system access with all permissions',
                'permissions' => [
                    'manage_users',
                    'manage_roles',
                    'manage_categories',
                    'view_all_tickets',
                    'manage_all_tickets',
                    'access_admin_dashboard',
                    'manage_system_settings'
                ]
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Administrative access with category restrictions',
                'permissions' => [
                    'manage_categories',
                    'view_assigned_tickets',
                    'manage_assigned_tickets',
                    'access_admin_dashboard'
                ]
            ],
            [
                'name' => 'hr_admin',
                'display_name' => 'HR Admin',
                'description' => 'HR department administrator',
                'permissions' => [
                    'view_assigned_tickets',
                    'manage_assigned_tickets',
                    'access_admin_dashboard',
                    'manage_user_data'
                ]
            ],
            [
                'name' => 'finance_admin',
                'display_name' => 'Finance Admin',
                'description' => 'Finance department administrator',
                'permissions' => [
                    'view_assigned_tickets',
                    'manage_assigned_tickets',
                    'access_admin_dashboard',
                    'manage_salary_tickets'
                ]
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'Regular employee user',
                'permissions' => [
                    'create_tickets',
                    'view_own_tickets',
                    'update_own_profile'
                ]
            ]
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );
        }
    }
}
