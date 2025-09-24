<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'IT Támogatás',
                'description' => 'Informatikai problémák és kérések',
                'form_fields' => [
                    [
                        'name' => 'problem_type',
                        'label' => 'Probléma típusa',
                        'type' => 'select',
                        'required' => true,
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
                        'name' => 'urgency',
                        'label' => 'Sürgősség',
                        'type' => 'select',
                        'required' => true,
                        'options' => [
                            'low' => 'Alacsony - Nem sürgős',
                            'medium' => 'Közepes - 1-2 napon belül',
                            'high' => 'Magas - Azonnal szükséges',
                            'critical' => 'Kritikus - Munka leáll'
                        ]
                    ],
                    [
                        'name' => 'device_info',
                        'label' => 'Eszköz információ',
                        'type' => 'text',
                        'required' => false,
                        'placeholder' => 'Számítógép neve, típusa, stb.'
                    ],
                    [
                        'name' => 'error_message',
                        'label' => 'Hibaüzenet',
                        'type' => 'textarea',
                        'required' => false,
                        'placeholder' => 'Pontos hibaüzenet vagy probléma leírása'
                    ],
                    [
                        'name' => 'screenshot',
                        'label' => 'Képernyőkép',
                        'type' => 'file',
                        'required' => false,
                        'accept' => 'image/*'
                    ]
                ]
            ],
            [
                'name' => 'HR Kérések',
                'description' => 'Humán erőforrás kapcsolatos kérések',
                'form_fields' => [
                    [
                        'name' => 'request_type',
                        'label' => 'Kérés típusa',
                        'type' => 'select',
                        'required' => true,
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
                        'name' => 'start_date',
                        'label' => 'Kezdő dátum',
                        'type' => 'date',
                        'required' => false
                    ],
                    [
                        'name' => 'end_date',
                        'label' => 'Befejező dátum',
                        'type' => 'date',
                        'required' => false
                    ],
                    [
                        'name' => 'reason',
                        'label' => 'Indoklás',
                        'type' => 'textarea',
                        'required' => true,
                        'placeholder' => 'Részletes indoklás a kéréshez'
                    ],
                    [
                        'name' => 'supporting_document',
                        'label' => 'Támogató dokumentum',
                        'type' => 'file',
                        'required' => false,
                        'accept' => '.pdf,.doc,.docx,.jpg,.png'
                    ]
                ]
            ],
            [
                'name' => 'Adminisztráció',
                'description' => 'Adminisztratív kérések és problémák',
                'form_fields' => [
                    [
                        'name' => 'admin_type',
                        'label' => 'Adminisztratív kérés típusa',
                        'type' => 'select',
                        'required' => true,
                        'options' => [
                            'access_card' => 'Belépőkártya probléma',
                            'parking' => 'Parkolási kérelem',
                            'office_supplies' => 'Irodaszer kérés',
                            'maintenance' => 'Karbantartási kérés',
                            'security' => 'Biztonsági probléma',
                            'cleaning' => 'Takarítási kérés',
                            'other' => 'Egyéb adminisztratív kérés'
                        ]
                    ],
                    [
                        'name' => 'location',
                        'label' => 'Helyszín',
                        'type' => 'text',
                        'required' => false,
                        'placeholder' => 'Épület, szint, iroda száma'
                    ],
                    [
                        'name' => 'priority',
                        'label' => 'Prioritás',
                        'type' => 'select',
                        'required' => true,
                        'options' => [
                            'low' => 'Alacsony',
                            'medium' => 'Közepes',
                            'high' => 'Magas',
                            'urgent' => 'Sürgős'
                        ]
                    ],
                    [
                        'name' => 'details',
                        'label' => 'Részletes leírás',
                        'type' => 'textarea',
                        'required' => true,
                        'placeholder' => 'Részletesen írja le a kérést vagy problémát'
                    ]
                ]
            ],
            [
                'name' => 'Pénzügy',
                'description' => 'Pénzügyi kérések és elszámolások',
                'form_fields' => [
                    [
                        'name' => 'finance_type',
                        'label' => 'Pénzügyi kérés típusa',
                        'type' => 'select',
                        'required' => true,
                        'options' => [
                            'expense_report' => 'Költségelszámolás',
                            'advance_payment' => 'Előleg kérés',
                            'invoice_question' => 'Számla kérdés',
                            'salary_question' => 'Fizetés kérdés',
                            'tax_certificate' => 'Adóigazolás kérés',
                            'travel_expense' => 'Utazási költség',
                            'other' => 'Egyéb pénzügyi kérés'
                        ]
                    ],
                    [
                        'name' => 'amount',
                        'label' => 'Összeg (HUF)',
                        'type' => 'number',
                        'required' => false,
                        'placeholder' => 'Kért vagy elszámolt összeg'
                    ],
                    [
                        'name' => 'expense_date',
                        'label' => 'Költség dátuma',
                        'type' => 'date',
                        'required' => false
                    ],
                    [
                        'name' => 'description',
                        'label' => 'Leírás',
                        'type' => 'textarea',
                        'required' => true,
                        'placeholder' => 'Részletes leírás a pénzügyi kérésről'
                    ],
                    [
                        'name' => 'receipts',
                        'label' => 'Számlák/Bizonylatok',
                        'type' => 'file',
                        'required' => false,
                        'accept' => '.pdf,.jpg,.png'
                    ]
                ]
            ],
            [
                'name' => 'Általános Kérések',
                'description' => 'Egyéb általános kérések és javaslatok',
                'form_fields' => [
                    [
                        'name' => 'request_category',
                        'label' => 'Kérés kategória',
                        'type' => 'select',
                        'required' => true,
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
                        'name' => 'subject',
                        'label' => 'Tárgy',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Rövid összefoglaló a kérésről'
                    ],
                    [
                        'name' => 'message',
                        'label' => 'Üzenet',
                        'type' => 'textarea',
                        'required' => true,
                        'placeholder' => 'Részletes üzenet vagy kérés'
                    ],
                    [
                        'name' => 'attachment',
                        'label' => 'Melléklet',
                        'type' => 'file',
                        'required' => false,
                        'accept' => '.pdf,.doc,.docx,.jpg,.png'
                    ]
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['name' => $categoryData['name']],
                [
                    'description' => $categoryData['description'],
                    'form_fields' => json_encode($categoryData['form_fields'])
                ]
            );
        }
    }
}
