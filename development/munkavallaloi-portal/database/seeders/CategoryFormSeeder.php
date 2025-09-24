<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\FormField;

class CategoryFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create basic form field types that can be reused
        $formFields = [
            // Rövid szöveg mezők (255 karakter)
            ['name' => 'rovid_szoveg_nev', 'type' => 'text'],
            ['name' => 'rovid_szoveg_cim', 'type' => 'text'],
            ['name' => 'rovid_szoveg_hely', 'type' => 'text'],
            ['name' => 'rovid_szoveg_telefonszam', 'type' => 'text'],
            ['name' => 'rovid_szoveg_email', 'type' => 'text'],
            ['name' => 'rovid_szoveg_egyeb', 'type' => 'text'],
            
            // Hosszú szöveg mezők (korlátlan)
            ['name' => 'hosszu_szoveg_leiras', 'type' => 'textarea'],
            ['name' => 'hosszu_szoveg_indoklas', 'type' => 'textarea'],
            ['name' => 'hosszu_szoveg_megjegyzes', 'type' => 'textarea'],
            ['name' => 'hosszu_szoveg_uzenet', 'type' => 'textarea'],
            
            // Legördülő listák
            ['name' => 'lista_tipus', 'type' => 'select'],
            ['name' => 'lista_prioritas', 'type' => 'select'],
            ['name' => 'lista_statusz', 'type' => 'select'],
            ['name' => 'lista_kategoria', 'type' => 'select'],
            
            // Dátum mezők
            ['name' => 'datum_kezdes', 'type' => 'date'],
            ['name' => 'datum_befejezés', 'type' => 'date'],
            ['name' => 'datum_hataridő', 'type' => 'date'],
            
            // Szám mezők
            ['name' => 'szam_osszeg', 'type' => 'number'],
            ['name' => 'szam_mennyiseg', 'type' => 'number'],
            ['name' => 'szam_ar', 'type' => 'number'],
            
            // Fájl mezők
            ['name' => 'fajl_melleklet', 'type' => 'file'],
            ['name' => 'fajl_dokumentum', 'type' => 'file'],
            ['name' => 'fajl_kepernyo', 'type' => 'file'],
        ];

        foreach ($formFields as $fieldData) {
            FormField::updateOrCreate(
                ['name' => $fieldData['name']],
                $fieldData
            );
        }

        // Create comprehensive categories
        $categoryConfigs = [
            [
                'name' => 'IT Támogatás',
                'description' => 'Informatikai problémák és kérések',
                'fields' => [
                    [
                        'field_name' => 'lista_tipus',
                        'label' => 'Probléma típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'hardware' => 'Hardver probléma',
                            'software' => 'Szoftver probléma',
                            'network' => 'Hálózati probléma',
                            'email' => 'Email probléma',
                            'printer' => 'Nyomtató probléma',
                            'other' => 'Egyéb'
                        ]
                    ],
                    [
                        'field_name' => 'rovid_szoveg_nev',
                        'label' => 'Eszköz/Számítógép neve',
                        'required' => false,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'hosszu_szoveg_leiras',
                        'label' => 'Probléma részletes leírása',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'fajl_kepernyo',
                        'label' => 'Képernyőkép a hibáról',
                        'required' => false,
                        'order' => 4
                    ]
                ]
            ],
            [
                'name' => 'HR Kérések',
                'description' => 'Humán erőforrás kapcsolatos kérések',
                'fields' => [
                    [
                        'field_name' => 'lista_kategoria',
                        'label' => 'Kérés típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'leave' => 'Szabadság kérelem',
                            'sick_leave' => 'Betegszabadság',
                            'certificate' => 'Igazolás kérés',
                            'training' => 'Képzés kérelem',
                            'complaint' => 'Panasz',
                            'other' => 'Egyéb HR kérés'
                        ]
                    ],
                    [
                        'field_name' => 'datum_kezdes',
                        'label' => 'Kezdő dátum',
                        'required' => false,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'datum_befejezés',
                        'label' => 'Befejező dátum',
                        'required' => false,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'hosszu_szoveg_indoklas',
                        'label' => 'Indoklás/Részletek',
                        'required' => true,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'fajl_dokumentum',
                        'label' => 'Támogató dokumentum',
                        'required' => false,
                        'order' => 5
                    ]
                ]
            ],
            [
                'name' => 'Munkabér Kérdés',
                'description' => 'Fizetéssel kapcsolatos kérdések és problémák',
                'fields' => [
                    [
                        'field_name' => 'lista_tipus',
                        'label' => 'Probléma típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'missing_payment' => 'Elmaradt fizetés',
                            'incorrect_amount' => 'Hibás összeg',
                            'overtime_missing' => 'Túlóra hiányzik',
                            'bonus_missing' => 'Prémium hiányzik',
                            'deduction_question' => 'Levonás kérdés',
                            'payslip_error' => 'Bérszámfejtés hiba',
                            'other' => 'Egyéb bér kérdés'
                        ]
                    ],
                    [
                        'field_name' => 'szam_osszeg',
                        'label' => 'Érintett összeg (EUR)',
                        'required' => false,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'datum_kezdes',
                        'label' => 'Fizetési időszak',
                        'required' => false,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'hosszu_szoveg_leiras',
                        'label' => 'Probléma részletes leírása',
                        'required' => true,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'fajl_dokumentum',
                        'label' => 'Bérszámfejtés/Dokumentum',
                        'required' => false,
                        'order' => 5
                    ]
                ]
            ],
            [
                'name' => 'Utalás Kérdés',
                'description' => 'Pénzátutalási kérések (bér, előleg, menetlevelek)',
                'fields' => [
                    [
                        'field_name' => 'lista_tipus',
                        'label' => 'Utalás típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'salary_transfer' => 'Bér átutalás',
                            'advance_payment' => 'Előleg kifizetés',
                            'travel_allowance' => 'Menetlevél/Utazási költség',
                            'expense_reimbursement' => 'Költségtérítés',
                            'bonus_payment' => 'Prémium kifizetés',
                            'other_transfer' => 'Egyéb átutalás'
                        ]
                    ],
                    [
                        'field_name' => 'szam_osszeg',
                        'label' => 'Összeg (EUR)',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'rovid_szoveg_nev',
                        'label' => 'Kedvezményezett neve',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'rovid_szoveg_egyeb',
                        'label' => 'Számlaszám/IBAN',
                        'required' => true,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'hosszu_szoveg_indoklas',
                        'label' => 'Átutalás célja/Indoklás',
                        'required' => true,
                        'order' => 5
                    ],
                    [
                        'field_name' => 'fajl_melleklet',
                        'label' => 'Támogató dokumentumok',
                        'required' => false,
                        'order' => 6
                    ]
                ]
            ],
            [
                'name' => 'Lakás/Szállás',
                'description' => 'Szállás és lakhatási kérések',
                'fields' => [
                    [
                        'field_name' => 'lista_tipus',
                        'label' => 'Szállás típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'apartment' => 'Lakás bérlés',
                            'room' => 'Szoba bérlés',
                            'hostel' => 'Hostel/Kollégium',
                            'hotel' => 'Hotel szállás',
                            'temporary' => 'Ideiglenes szállás'
                        ]
                    ],
                    [
                        'field_name' => 'datum_kezdes',
                        'label' => 'Beköltözés dátuma',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'datum_befejezés',
                        'label' => 'Kiköltözés dátuma (ha ismert)',
                        'required' => false,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'rovid_szoveg_hely',
                        'label' => 'Preferált helyszín',
                        'required' => false,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'hosszu_szoveg_megjegyzes',
                        'label' => 'Különleges igények/Megjegyzések',
                        'required' => false,
                        'order' => 5
                    ]
                ]
            ],
            [
                'name' => 'Munkáltatói Igazolás',
                'description' => 'Munkáltatói igazolások kérése',
                'fields' => [
                    [
                        'field_name' => 'lista_tipus',
                        'label' => 'Igazolás típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'employment' => 'Munkaviszony igazolás',
                            'salary' => 'Jövedelemigazolás',
                            'experience' => 'Munkatapasztalat igazolás',
                            'character' => 'Erkölcsi bizonyítvány',
                            'custom' => 'Egyedi igazolás'
                        ]
                    ],
                    [
                        'field_name' => 'hosszu_szoveg_indoklas',
                        'label' => 'Igazolás célja',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'datum_hataridő',
                        'label' => 'Szükséges dátum',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'rovid_szoveg_email',
                        'label' => 'Email cím (kézbesítéshez)',
                        'required' => false,
                        'order' => 4
                    ]
                ]
            ],
            [
                'name' => 'Repjegy/Csomag',
                'description' => 'Repülőjegy foglalás és csomag küldés',
                'fields' => [
                    [
                        'field_name' => 'lista_tipus',
                        'label' => 'Kérés típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'flight_booking' => 'Repülőjegy foglalás',
                            'package_send' => 'Csomag küldés',
                            'package_receive' => 'Csomag fogadás',
                            'flight_change' => 'Jegy módosítás',
                            'flight_cancel' => 'Jegy lemondás'
                        ]
                    ],
                    [
                        'field_name' => 'rovid_szoveg_hely',
                        'label' => 'Indulási hely/Feladó',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'rovid_szoveg_cim',
                        'label' => 'Célállomás/Címzett',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'datum_kezdes',
                        'label' => 'Indulás/Küldés dátuma',
                        'required' => true,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'datum_befejezés',
                        'label' => 'Visszaút dátuma (ha szükséges)',
                        'required' => false,
                        'order' => 5
                    ],
                    [
                        'field_name' => 'szam_mennyiseg',
                        'label' => 'Utasok száma/Csomagok száma',
                        'required' => true,
                        'order' => 6
                    ],
                    [
                        'field_name' => 'hosszu_szoveg_megjegyzes',
                        'label' => 'Részletek/Megjegyzések',
                        'required' => true,
                        'order' => 7
                    ]
                ]
            ],
            [
                'name' => 'Bérelt Autó',
                'description' => 'Autóbérlési kérések és problémák',
                'fields' => [
                    [
                        'field_name' => 'lista_tipus',
                        'label' => 'Bérlés típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'business_trip' => 'Üzleti út',
                            'airport_transfer' => 'Repülőtéri transzfer',
                            'local_transport' => 'Helyi közlekedés',
                            'long_term' => 'Hosszú távú bérlés',
                            'emergency' => 'Sürgősségi autó',
                            'problem_report' => 'Probléma bejelentés'
                        ]
                    ],
                    [
                        'field_name' => 'lista_kategoria',
                        'label' => 'Autó kategória',
                        'required' => true,
                        'order' => 2,
                        'options' => [
                            'economy' => 'Gazdaságos',
                            'compact' => 'Kompakt',
                            'intermediate' => 'Középkategória',
                            'full_size' => 'Nagy méretű',
                            'luxury' => 'Luxus',
                            'van' => 'Kisbusz/Van'
                        ]
                    ],
                    [
                        'field_name' => 'datum_kezdes',
                        'label' => 'Átvétel dátuma',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'datum_befejezés',
                        'label' => 'Visszaadás dátuma',
                        'required' => true,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'rovid_szoveg_hely',
                        'label' => 'Átvételi helyszín',
                        'required' => true,
                        'order' => 5
                    ],
                    [
                        'field_name' => 'rovid_szoveg_cim',
                        'label' => 'Visszaadási helyszín',
                        'required' => false,
                        'order' => 6
                    ],
                    [
                        'field_name' => 'hosszu_szoveg_megjegyzes',
                        'label' => 'Bérlés célja/Különleges igények',
                        'required' => true,
                        'order' => 7
                    ]
                ]
            ],
            [
                'name' => 'Általános Kérés',
                'description' => 'Egyéb általános kérések és javaslatok',
                'fields' => [
                    [
                        'field_name' => 'lista_kategoria',
                        'label' => 'Kérés kategória',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'suggestion' => 'Javaslat/Ötlet',
                            'complaint' => 'Panasz',
                            'compliment' => 'Dicséret',
                            'question' => 'Kérdés',
                            'feedback' => 'Visszajelzés',
                            'other' => 'Egyéb'
                        ]
                    ],
                    [
                        'field_name' => 'rovid_szoveg_cim',
                        'label' => 'Tárgy',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'hosszu_szoveg_uzenet',
                        'label' => 'Üzenet',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'fajl_melleklet',
                        'label' => 'Melléklet',
                        'required' => false,
                        'order' => 4
                    ]
                ]
            ]
        ];

        // Process each category
        foreach ($categoryConfigs as $categoryConfig) {
            // Create or update category
            $category = Category::updateOrCreate(
                ['name' => $categoryConfig['name']],
                ['description' => $categoryConfig['description']]
            );

            // Clear existing form field associations
            $category->formFields()->detach();

            // Add form fields to category
            foreach ($categoryConfig['fields'] as $fieldConfig) {
                $formField = FormField::where('name', $fieldConfig['field_name'])->first();
                
                if ($formField) {
                    $category->formFields()->attach($formField->id, [
                        'label' => $fieldConfig['label'],
                        'is_required' => $fieldConfig['required'],
                        'order' => $fieldConfig['order'],
                        'field_options' => isset($fieldConfig['options']) ? json_encode($fieldConfig['options']) : null
                    ]);
                }
            }
        }
    }
}
