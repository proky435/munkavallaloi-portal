<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Lakás',
                'form_type' => 'housing',
                'description' => 'Lakhatással kapcsolatos kérdések és problémák',
                'requires_attachment' => false,
            ],
            [
                'name' => 'Munkabér kérdés (összeg)',
                'form_type' => 'salary',
                'description' => 'Fizetéssel kapcsolatos kérdések',
                'requires_attachment' => false,
            ],
            [
                'name' => 'Utalás kérdés (bér, előleg, menetlevelek)',
                'form_type' => 'transfer',
                'description' => 'Pénzügyi utalásokkal kapcsolatos kérdések',
                'requires_attachment' => false,
            ],
            [
                'name' => 'Munkáltatói igazolás',
                'form_type' => 'employer_certificate',
                'description' => 'Munkáltatói igazolás kérése',
                'requires_attachment' => true,
            ],
            [
                'name' => 'Repjegy / csomag',
                'form_type' => 'flight_package',
                'description' => 'Repülőjegy és csomag kérdések',
                'requires_attachment' => false,
            ],
            [
                'name' => 'Bérelt autó',
                'form_type' => 'rental_car',
                'description' => 'Autóbérlés kérdések',
                'requires_attachment' => false,
            ],
            [
                'name' => 'Adatváltozás bejelentés',
                'form_type' => 'data_change',
                'description' => 'Személyes adatok módosítása',
                'requires_attachment' => true,
            ],
            [
                'name' => 'Technikai probléma',
                'form_type' => 'technical',
                'description' => 'Technikai problémák bejelentése',
                'requires_attachment' => false,
            ],
            [
                'name' => 'Általános kérdés',
                'form_type' => 'general',
                'description' => 'Egyéb kérdések',
                'requires_attachment' => false,
            ],
        ];

        foreach ($categories as $categoryData) {
            // Add slug and responsible_email
            $categoryData['slug'] = \Illuminate\Support\Str::slug($categoryData['name']);
            $categoryData['responsible_email'] = match($categoryData['form_type']) {
                'housing' => 'housing@company.com',
                'salary' => 'payroll@company.com', 
                'transfer' => 'finance@company.com',
                'employer_certificate' => 'hr@company.com',
                'flight_package' => 'travel@company.com',
                'rental_car' => 'fleet@company.com',
                'data_change' => 'hr@company.com',
                'technical' => 'it@company.com',
                'general' => 'info@company.com',
                default => 'info@company.com'
            };
            
            Category::firstOrCreate(
                ['name' => $categoryData['name']], 
                $categoryData
            );
        }
    }
}
