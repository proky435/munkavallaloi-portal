<?php

namespace Database\Seeders;

use App\Models\Workplace;
use Illuminate\Database\Seeder;

class WorkplaceSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $workplaces = [
            [
                'name' => 'Brema',
                'code' => 'BRE',
                'address' => 'Brema utca 1.',
                'city' => 'Brema',
                'country' => 'Németország',
                'phone' => '+49 421 123456',
                'email' => 'brema@company.com',
                'is_active' => true,
            ],
            [
                'name' => 'Boden',
                'code' => 'BOD',
                'address' => 'Boden utca 1.',
                'city' => 'Boden',
                'country' => 'Svédország',
                'phone' => '+46 921 123456',
                'email' => 'boden@company.com',
                'is_active' => true,
            ],
            [
                'name' => 'Tarragona',
                'code' => 'TAR',
                'address' => 'Tarragona utca 1.',
                'city' => 'Tarragona',
                'country' => 'Spanyolország',
                'phone' => '+34 977 123456',
                'email' => 'tarragona@company.com',
                'is_active' => true,
            ],
        ];

        foreach ($workplaces as $workplace) {
            Workplace::create($workplace);
        }
    }
}
