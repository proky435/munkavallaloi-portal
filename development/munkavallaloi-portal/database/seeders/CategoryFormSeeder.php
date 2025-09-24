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
        // First, create the form fields
        $formFields = [
            // Text fields
            ['name' => 'problem_type', 'type' => 'select'],
            ['name' => 'urgency', 'type' => 'select'],
            ['name' => 'device_info', 'type' => 'text'],
            ['name' => 'error_message', 'type' => 'textarea'],
            ['name' => 'screenshot', 'type' => 'file'],
            ['name' => 'request_type', 'type' => 'select'],
            ['name' => 'start_date', 'type' => 'date'],
            ['name' => 'end_date', 'type' => 'date'],
            ['name' => 'reason', 'type' => 'textarea'],
            ['name' => 'supporting_document', 'type' => 'file'],
            ['name' => 'admin_type', 'type' => 'select'],
            ['name' => 'location', 'type' => 'text'],
            ['name' => 'priority', 'type' => 'select'],
            ['name' => 'details', 'type' => 'textarea'],
            ['name' => 'finance_type', 'type' => 'select'],
            ['name' => 'amount', 'type' => 'number'],
            ['name' => 'expense_date', 'type' => 'date'],
            ['name' => 'description', 'type' => 'textarea'],
            ['name' => 'receipts', 'type' => 'file'],
            ['name' => 'request_category', 'type' => 'select'],
            ['name' => 'subject', 'type' => 'text'],
            ['name' => 'message', 'type' => 'textarea'],
            ['name' => 'attachment', 'type' => 'file'],
            // Lakás kategória mezők
            ['name' => 'accommodation_type', 'type' => 'select'],
            ['name' => 'move_in_date', 'type' => 'date'],
            ['name' => 'move_out_date', 'type' => 'date'],
            ['name' => 'room_type', 'type' => 'select'],
            ['name' => 'special_requirements', 'type' => 'textarea'],
            // Munkabér kategória mezők
            ['name' => 'salary_issue_type', 'type' => 'select'],
            ['name' => 'pay_period', 'type' => 'select'],
            ['name' => 'expected_amount', 'type' => 'number'],
            ['name' => 'actual_amount', 'type' => 'number'],
            ['name' => 'payslip_attachment', 'type' => 'file'],
            // Utalás kategória mezők
            ['name' => 'transfer_type', 'type' => 'select'],
            ['name' => 'transfer_amount', 'type' => 'number'],
            ['name' => 'recipient_name', 'type' => 'text'],
            ['name' => 'recipient_account', 'type' => 'text'],
            ['name' => 'transfer_purpose', 'type' => 'textarea'],
            // Munkáltatói igazolás kategória mezők
            ['name' => 'certificate_type', 'type' => 'select'],
            ['name' => 'certificate_purpose', 'type' => 'textarea'],
            ['name' => 'needed_by_date', 'type' => 'date'],
            ['name' => 'delivery_method', 'type' => 'select'],
            ['name' => 'delivery_address', 'type' => 'textarea'],
            // Repjegy kategória mezők
            ['name' => 'flight_type', 'type' => 'select'],
            ['name' => 'departure_city', 'type' => 'text'],
            ['name' => 'destination_city', 'type' => 'text'],
            ['name' => 'departure_date', 'type' => 'date'],
            ['name' => 'return_date', 'type' => 'date'],
            ['name' => 'passenger_count', 'type' => 'number'],
            ['name' => 'travel_purpose', 'type' => 'textarea'],
            // Bérelt autó kategória mezők
            ['name' => 'rental_type', 'type' => 'select'],
            ['name' => 'car_category', 'type' => 'select'],
            ['name' => 'pickup_date', 'type' => 'date'],
            ['name' => 'return_date_car', 'type' => 'date'],
            ['name' => 'pickup_location', 'type' => 'text'],
            ['name' => 'return_location', 'type' => 'text'],
            ['name' => 'rental_purpose', 'type' => 'textarea'],
            // Technikai probléma kategória mezők
            ['name' => 'tech_problem_type', 'type' => 'select'],
            ['name' => 'affected_system', 'type' => 'text'],
            ['name' => 'problem_description', 'type' => 'textarea'],
            ['name' => 'error_screenshot', 'type' => 'file'],
            ['name' => 'tech_urgency', 'type' => 'select'],
        ];

        foreach ($formFields as $fieldData) {
            FormField::updateOrCreate(
                ['name' => $fieldData['name']],
                $fieldData
            );
        }

        // Now create categories and assign form fields
        $categoryConfigs = [
            [
                'name' => 'IT Támogatás',
                'description' => 'Informatikai problémák és kérések',
                'fields' => [
                    [
                        'field_name' => 'problem_type',
                        'label' => 'Probléma típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'hardware' => 'Hardver probléma',
                            'software' => 'Szoftver probléma',
                            'network' => 'Hálózati probléma',
                            'email' => 'Email probléma',
                            'printer' => 'Nyomtató probléma',
                            'access' => 'Hozzáférési probléma',
                            'other' => 'Egyéb'
                        ]
                    ],
                    [
                        'field_name' => 'urgency',
                        'label' => 'Sürgősség',
                        'required' => true,
                        'order' => 2,
                        'options' => [
                            'low' => 'Alacsony - Nem sürgős',
                            'medium' => 'Közepes - 1-2 napon belül',
                            'high' => 'Magas - Azonnal szükséges',
                            'critical' => 'Kritikus - Munka leáll'
                        ]
                    ],
                    [
                        'field_name' => 'device_info',
                        'label' => 'Eszköz információ',
                        'required' => false,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'error_message',
                        'label' => 'Hibaüzenet',
                        'required' => false,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'screenshot',
                        'label' => 'Képernyőkép',
                        'required' => false,
                        'order' => 5
                    ]
                ]
            ],
            [
                'name' => 'HR Kérések',
                'description' => 'Humán erőforrás kapcsolatos kérések',
                'fields' => [
                    [
                        'field_name' => 'request_type',
                        'label' => 'Kérés típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'leave' => 'Szabadság kérelem',
                            'sick_leave' => 'Betegszabadság',
                            'overtime' => 'Túlóra elszámolás',
                            'certificate' => 'Igazolás kérés',
                            'training' => 'Képzés kérelem',
                            'complaint' => 'Panasz bejelentés',
                            'other' => 'Egyéb HR kérés'
                        ]
                    ],
                    [
                        'field_name' => 'start_date',
                        'label' => 'Kezdő dátum',
                        'required' => false,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'end_date',
                        'label' => 'Befejező dátum',
                        'required' => false,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'reason',
                        'label' => 'Indoklás',
                        'required' => true,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'supporting_document',
                        'label' => 'Támogató dokumentum',
                        'required' => false,
                        'order' => 5
                    ]
                ]
            ],
            [
                'name' => 'Lakás',
                'description' => 'Szállás és lakhatási kérések',
                'fields' => [
                    [
                        'field_name' => 'accommodation_type',
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
                        'field_name' => 'move_in_date',
                        'label' => 'Beköltözés dátuma',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'move_out_date',
                        'label' => 'Kiköltözés dátuma',
                        'required' => false,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'room_type',
                        'label' => 'Szoba típus',
                        'required' => false,
                        'order' => 4,
                        'options' => [
                            'single' => 'Egyágyas',
                            'double' => 'Kétágyas',
                            'shared' => 'Megosztott',
                            'studio' => 'Stúdió',
                            'apartment' => 'Teljes lakás'
                        ]
                    ],
                    [
                        'field_name' => 'special_requirements',
                        'label' => 'Különleges igények',
                        'required' => false,
                        'order' => 5
                    ]
                ]
            ],
            [
                'name' => 'Munkabér',
                'description' => 'Fizetéssel kapcsolatos kérdések és problémák',
                'fields' => [
                    [
                        'field_name' => 'salary_issue_type',
                        'label' => 'Probléma típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'missing_payment' => 'Elmaradt fizetés',
                            'incorrect_amount' => 'Hibás összeg',
                            'overtime_missing' => 'Túlóra hiányzik',
                            'bonus_missing' => 'Prémium hiányzik',
                            'deduction_question' => 'Levonás kérdés',
                            'payslip_error' => 'Bérszámfejtés hiba'
                        ]
                    ],
                    [
                        'field_name' => 'pay_period',
                        'label' => 'Fizetési időszak',
                        'required' => true,
                        'order' => 2,
                        'options' => [
                            'current_month' => 'Aktuális hónap',
                            'previous_month' => 'Előző hónap',
                            'specific_period' => 'Meghatározott időszak'
                        ]
                    ],
                    [
                        'field_name' => 'expected_amount',
                        'label' => 'Várt összeg (EUR)',
                        'required' => false,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'actual_amount',
                        'label' => 'Kapott összeg (EUR)',
                        'required' => false,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'payslip_attachment',
                        'label' => 'Bérszámfejtés melléklet',
                        'required' => false,
                        'order' => 5
                    ]
                ]
            ],
            [
                'name' => 'Utalás',
                'description' => 'Pénzátutalási kérések és problémák',
                'fields' => [
                    [
                        'field_name' => 'transfer_type',
                        'label' => 'Utalás típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'salary_transfer' => 'Fizetés átutalás',
                            'expense_reimbursement' => 'Költségtérítés',
                            'advance_payment' => 'Előleg',
                            'bonus_payment' => 'Prémium kifizetés',
                            'other_transfer' => 'Egyéb átutalás'
                        ]
                    ],
                    [
                        'field_name' => 'transfer_amount',
                        'label' => 'Összeg (EUR)',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'recipient_name',
                        'label' => 'Kedvezményezett neve',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'recipient_account',
                        'label' => 'Kedvezményezett számlaszáma',
                        'required' => true,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'transfer_purpose',
                        'label' => 'Átutalás célja',
                        'required' => true,
                        'order' => 5
                    ]
                ]
            ],
            [
                'name' => 'Munkáltatói igazolás',
                'description' => 'Munkáltatói igazolások kérése',
                'fields' => [
                    [
                        'field_name' => 'certificate_type',
                        'label' => 'Igazolás típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'employment_certificate' => 'Munkaviszony igazolás',
                            'salary_certificate' => 'Jövedelemigazolás',
                            'work_experience' => 'Munkatapasztalat igazolás',
                            'character_reference' => 'Erkölcsi bizonyítvány',
                            'custom_certificate' => 'Egyedi igazolás'
                        ]
                    ],
                    [
                        'field_name' => 'certificate_purpose',
                        'label' => 'Igazolás célja',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'needed_by_date',
                        'label' => 'Szükséges dátum',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'delivery_method',
                        'label' => 'Kézbesítési mód',
                        'required' => true,
                        'order' => 4,
                        'options' => [
                            'email' => 'Email',
                            'postal_mail' => 'Postai küldemény',
                            'personal_pickup' => 'Személyes átvétel',
                            'courier' => 'Futárszolgálat'
                        ]
                    ],
                    [
                        'field_name' => 'delivery_address',
                        'label' => 'Kézbesítési cím',
                        'required' => false,
                        'order' => 5
                    ]
                ]
            ],
            [
                'name' => 'Repjegy',
                'description' => 'Repülőjegy foglalási kérések',
                'fields' => [
                    [
                        'field_name' => 'flight_type',
                        'label' => 'Repülés típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'one_way' => 'Egyirányú',
                            'round_trip' => 'Oda-vissza',
                            'multi_city' => 'Több város'
                        ]
                    ],
                    [
                        'field_name' => 'departure_city',
                        'label' => 'Indulási város',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'destination_city',
                        'label' => 'Célállomás',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'departure_date',
                        'label' => 'Indulás dátuma',
                        'required' => true,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'return_date',
                        'label' => 'Visszaút dátuma',
                        'required' => false,
                        'order' => 5
                    ],
                    [
                        'field_name' => 'passenger_count',
                        'label' => 'Utasok száma',
                        'required' => true,
                        'order' => 6
                    ],
                    [
                        'field_name' => 'travel_purpose',
                        'label' => 'Utazás célja',
                        'required' => true,
                        'order' => 7
                    ]
                ]
            ],
            [
                'name' => 'Bérelt autó',
                'description' => 'Autóbérlési kérések',
                'fields' => [
                    [
                        'field_name' => 'rental_type',
                        'label' => 'Bérlés típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'business_trip' => 'Üzleti út',
                            'airport_transfer' => 'Repülőtéri transzfer',
                            'local_transport' => 'Helyi közlekedés',
                            'long_term' => 'Hosszú távú bérlés'
                        ]
                    ],
                    [
                        'field_name' => 'car_category',
                        'label' => 'Autó kategória',
                        'required' => true,
                        'order' => 2,
                        'options' => [
                            'economy' => 'Gazdaságos',
                            'compact' => 'Kompakt',
                            'intermediate' => 'Középkategória',
                            'full_size' => 'Nagy méretű',
                            'luxury' => 'Luxus',
                            'van' => 'Kisbusz'
                        ]
                    ],
                    [
                        'field_name' => 'pickup_date',
                        'label' => 'Átvétel dátuma',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'return_date_car',
                        'label' => 'Visszaadás dátuma',
                        'required' => true,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'pickup_location',
                        'label' => 'Átvételi helyszín',
                        'required' => true,
                        'order' => 5
                    ],
                    [
                        'field_name' => 'return_location',
                        'label' => 'Visszaadási helyszín',
                        'required' => true,
                        'order' => 6
                    ],
                    [
                        'field_name' => 'rental_purpose',
                        'label' => 'Bérlés célja',
                        'required' => true,
                        'order' => 7
                    ]
                ]
            ],
            [
                'name' => 'Technikai probléma',
                'description' => 'Technikai problémák és hibabejelentések',
                'fields' => [
                    [
                        'field_name' => 'tech_problem_type',
                        'label' => 'Probléma típusa',
                        'required' => true,
                        'order' => 1,
                        'options' => [
                            'system_error' => 'Rendszerhiba',
                            'login_issue' => 'Bejelentkezési probléma',
                            'performance_issue' => 'Teljesítmény probléma',
                            'data_loss' => 'Adatvesztés',
                            'connectivity_issue' => 'Kapcsolódási probléma',
                            'software_bug' => 'Szoftver hiba'
                        ]
                    ],
                    [
                        'field_name' => 'affected_system',
                        'label' => 'Érintett rendszer',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'problem_description',
                        'label' => 'Probléma leírása',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'error_screenshot',
                        'label' => 'Hiba képernyőkép',
                        'required' => false,
                        'order' => 4
                    ],
                    [
                        'field_name' => 'tech_urgency',
                        'label' => 'Sürgősség',
                        'required' => true,
                        'order' => 5,
                        'options' => [
                            'low' => 'Alacsony',
                            'medium' => 'Közepes',
                            'high' => 'Magas',
                            'critical' => 'Kritikus'
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Általános kérés',
                'description' => 'Egyéb általános kérések és javaslatok',
                'fields' => [
                    [
                        'field_name' => 'request_category',
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
                        'field_name' => 'subject',
                        'label' => 'Tárgy',
                        'required' => true,
                        'order' => 2
                    ],
                    [
                        'field_name' => 'message',
                        'label' => 'Üzenet',
                        'required' => true,
                        'order' => 3
                    ],
                    [
                        'field_name' => 'attachment',
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
