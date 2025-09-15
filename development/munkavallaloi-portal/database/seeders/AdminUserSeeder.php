<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Check if user already exists
        $existingUser = User::where('email', 'proky2003@gmail.com')->first();
        if ($existingUser) {
            $this->command->info('Admin user already exists: proky2003@gmail.com');
            return;
        }

        // Get super_admin role
        $superAdminRole = Role::where('name', 'super_admin')->first();
        
        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'proky2003@gmail.com',
            'password' => Hash::make('asdasdasd'),
            'role_id' => $superAdminRole ? $superAdminRole->id : 1,
            'is_first_login' => false,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created: proky2003@gmail.com / asdasdasd');
    }
}
