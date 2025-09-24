<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Workplace;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles and workplaces exist
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $hrAdminRole = Role::where('name', 'hr_admin')->first();
        $financeAdminRole = Role::where('name', 'finance_admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $bremaWorkplace = Workplace::where('name', 'Brema')->first();
        $bodenWorkplace = Workplace::where('name', 'Boden')->first();
        $tarragonaWorkplace = Workplace::where('name', 'Tarragona')->first();

        $testUsers = [
            [
                'name' => 'Super Admin Test',
                'email' => 'superadmin@test.com',
                'password' => Hash::make('asdasdasd'),
                'role_id' => $superAdminRole?->id,
                'workplace_id' => $bremaWorkplace?->id,
                'is_admin' => true,
                'email_verified_at' => now(),
                'phone' => '+36 30 111 1111',
                'birth_date' => '1985-01-15',
                'birth_place' => 'Budapest',
                'street_address' => 'Teszt utca 1.',
                'city' => 'Budapest',
                'postal_code' => '1111',
                'country' => 'Magyarország',
                'bank_account_number' => '12345678-12345678-12345678',
                'tax_number' => '12345678-1-23',
                'social_security_number' => '123456789',
                'emergency_contact_name' => 'Test Emergency Contact',
                'emergency_contact_phone' => '+36 30 999 9999'
            ],
            [
                'name' => 'Admin Test',
                'email' => 'admin@test.com',
                'password' => Hash::make('asdasdasd'),
                'role_id' => $adminRole?->id,
                'workplace_id' => $bremaWorkplace?->id,
                'is_admin' => true,
                'email_verified_at' => now(),
                'phone' => '+36 30 222 2222',
                'birth_date' => '1988-03-20',
                'birth_place' => 'Debrecen',
                'street_address' => 'Admin utca 2.',
                'city' => 'Debrecen',
                'postal_code' => '4000',
                'country' => 'Magyarország',
                'bank_account_number' => '87654321-87654321-87654321',
                'tax_number' => '87654321-2-34',
                'social_security_number' => '987654321',
                'emergency_contact_name' => 'Admin Emergency Contact',
                'emergency_contact_phone' => '+36 30 888 8888'
            ],
            [
                'name' => 'HR Admin Test',
                'email' => 'hradmin@test.com',
                'password' => Hash::make('asdasdasd'),
                'role_id' => $hrAdminRole?->id,
                'workplace_id' => $bodenWorkplace?->id,
                'is_admin' => false,
                'email_verified_at' => now(),
                'phone' => '+36 30 333 3333',
                'birth_date' => '1990-06-10',
                'birth_place' => 'Szeged',
                'street_address' => 'HR utca 3.',
                'city' => 'Szeged',
                'postal_code' => '6720',
                'country' => 'Magyarország',
                'bank_account_number' => '11111111-22222222-33333333',
                'tax_number' => '11111111-3-45',
                'social_security_number' => '111222333',
                'emergency_contact_name' => 'HR Emergency Contact',
                'emergency_contact_phone' => '+36 30 777 7777'
            ],
            [
                'name' => 'Finance Admin Test',
                'email' => 'financeadmin@test.com',
                'password' => Hash::make('asdasdasd'),
                'role_id' => $financeAdminRole?->id,
                'workplace_id' => $tarragonaWorkplace?->id,
                'is_admin' => false,
                'email_verified_at' => now(),
                'phone' => '+36 30 444 4444',
                'birth_date' => '1987-09-25',
                'birth_place' => 'Pécs',
                'street_address' => 'Finance utca 4.',
                'city' => 'Pécs',
                'postal_code' => '7600',
                'country' => 'Magyarország',
                'bank_account_number' => '44444444-55555555-66666666',
                'tax_number' => '44444444-4-56',
                'social_security_number' => '444555666',
                'emergency_contact_name' => 'Finance Emergency Contact',
                'emergency_contact_phone' => '+36 30 666 6666'
            ],
            [
                'name' => 'Regular User Test',
                'email' => 'user@test.com',
                'password' => Hash::make('asdasdasd'),
                'role_id' => $userRole?->id,
                'workplace_id' => $bremaWorkplace?->id,
                'is_admin' => false,
                'email_verified_at' => now(),
                'phone' => '+36 30 555 5555',
                'birth_date' => '1992-12-05',
                'birth_place' => 'Miskolc',
                'street_address' => 'User utca 5.',
                'city' => 'Miskolc',
                'postal_code' => '3525',
                'country' => 'Magyarország',
                'bank_account_number' => '77777777-88888888-99999999',
                'tax_number' => '77777777-5-67',
                'social_security_number' => '777888999',
                'emergency_contact_name' => 'User Emergency Contact',
                'emergency_contact_phone' => '+36 30 555 5555'
            ],
            [
                'name' => 'John Doe Employee',
                'email' => 'john.doe@test.com',
                'password' => Hash::make('asdasdasd'),
                'role_id' => $userRole?->id,
                'workplace_id' => $bodenWorkplace?->id,
                'is_admin' => false,
                'email_verified_at' => now(),
                'phone' => '+36 70 123 4567',
                'birth_date' => '1989-04-12',
                'birth_place' => 'Győr',
                'street_address' => 'Munkás utca 10.',
                'city' => 'Győr',
                'postal_code' => '9024',
                'country' => 'Magyarország',
                'bank_account_number' => '12312312-34534534-56756756',
                'tax_number' => '12312312-6-78',
                'social_security_number' => '123456789',
                'emergency_contact_name' => 'Jane Doe',
                'emergency_contact_phone' => '+36 70 987 6543'
            ],
            [
                'name' => 'Anna Smith Worker',
                'email' => 'anna.smith@test.com',
                'password' => Hash::make('asdasdasd'),
                'role_id' => $userRole?->id,
                'workplace_id' => $tarragonaWorkplace?->id,
                'is_admin' => false,
                'email_verified_at' => now(),
                'phone' => '+36 20 987 6543',
                'birth_date' => '1991-08-30',
                'birth_place' => 'Kecskemét',
                'street_address' => 'Dolgozó tér 7.',
                'city' => 'Kecskemét',
                'postal_code' => '6000',
                'country' => 'Magyarország',
                'bank_account_number' => '98765432-12345678-87654321',
                'tax_number' => '98765432-7-89',
                'social_security_number' => '987654321',
                'emergency_contact_name' => 'Peter Smith',
                'emergency_contact_phone' => '+36 20 123 4567'
            ]
        ];

        foreach ($testUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Test users created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: superadmin@test.com / asdasdasd');
        $this->command->info('Admin: admin@test.com / asdasdasd');
        $this->command->info('HR Admin: hradmin@test.com / asdasdasd');
        $this->command->info('Finance Admin: financeadmin@test.com / asdasdasd');
        $this->command->info('Regular User: user@test.com / asdasdasd');
        $this->command->info('John Doe: john.doe@test.com / asdasdasd');
        $this->command->info('Anna Smith: anna.smith@test.com / asdasdasd');
    }
}
