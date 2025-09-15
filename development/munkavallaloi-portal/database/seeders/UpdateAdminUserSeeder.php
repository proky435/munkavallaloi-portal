<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UpdateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Find or create the user
        $user = User::where('email', 'proky2003@gmail.com')->first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'proky2003@gmail.com',
                'password' => Hash::make('asdasdasd'),
                'email_verified_at' => now(),
            ]);
            $this->command->info('Created new user: proky2003@gmail.com');
        }

        // Set admin status
        $user->is_admin = true;
        
        // Assign super_admin role if it exists
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $user->role_id = $superAdminRole->id;
            $this->command->info('Assigned super_admin role');
        }
        
        $user->save();
        
        $this->command->info('Updated admin status for: proky2003@gmail.com');
        $this->command->info('Password: asdasdasd');
    }
}
