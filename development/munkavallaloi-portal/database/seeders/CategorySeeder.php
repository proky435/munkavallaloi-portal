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
            'Lakás',
            'Munkabér kérdés (összeg)',
            'Utalás kérdés (bér, előleg, menetlevelek)',
            'Munkáltatói igazolás',
            'Repjegy / csomag',
            'Bérelt autó',
            'Adatváltozás bejelentés',
            'Technikai probléma',
            'Általános kérdés',
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(['name' => $categoryName]);
        }
    }
}
