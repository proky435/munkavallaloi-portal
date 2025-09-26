<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataChangeType;

class DataChangeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataChangeTypes = [
            [
                'name' => 'name_change',
                'display_name' => 'Név módosítás',
                'description' => 'Teljes név megváltoztatása',
                'form_fields' => [
                    [
                        'name' => 'new_name',
                        'type' => 'text',
                        'label' => 'Új név',
                        'required' => true,
                        'validation' => 'required|string|max:255',
                        'field_mapping' => 'name'
                    ],
                    [
                        'name' => 'reason',
                        'type' => 'textarea',
                        'label' => 'Módosítás indoka',
                        'required' => true,
                        'validation' => 'required|string|max:1000'
                    ]
                ],
                'required_documents' => ['identity_document', 'marriage_certificate'],
                'sort_order' => 1
            ],
            [
                'name' => 'workplace_change',
                'display_name' => 'Munkahely módosítás',
                'description' => 'Munkahely megváltoztatása',
                'form_fields' => [
                    [
                        'name' => 'new_workplace_id',
                        'type' => 'select',
                        'label' => 'Új munkahely',
                        'required' => true,
                        'validation' => 'required|exists:workplaces,id',
                        'options_source' => 'workplaces',
                        'field_mapping' => 'workplace_id'
                    ],
                    [
                        'name' => 'start_date',
                        'type' => 'date',
                        'label' => 'Kezdés dátuma',
                        'required' => true,
                        'validation' => 'required|date|after_or_equal:today'
                    ],
                    [
                        'name' => 'reason',
                        'type' => 'textarea',
                        'label' => 'Módosítás indoka',
                        'required' => false,
                        'validation' => 'nullable|string|max:1000'
                    ]
                ],
                'required_documents' => ['transfer_request'],
                'sort_order' => 2
            ],
            [
                'name' => 'address_change',
                'display_name' => 'Lakcím módosítás',
                'description' => 'Lakcím adatok megváltoztatása',
                'form_fields' => [
                    [
                        'name' => 'new_street_address',
                        'type' => 'text',
                        'label' => 'Új utca, házszám',
                        'required' => true,
                        'validation' => 'required|string|max:255',
                        'field_mapping' => 'street_address'
                    ],
                    [
                        'name' => 'new_city',
                        'type' => 'text',
                        'label' => 'Új város',
                        'required' => true,
                        'validation' => 'required|string|max:255',
                        'field_mapping' => 'city'
                    ],
                    [
                        'name' => 'new_postal_code',
                        'type' => 'text',
                        'label' => 'Új irányítószám',
                        'required' => true,
                        'validation' => 'required|string|max:20',
                        'field_mapping' => 'postal_code'
                    ],
                    [
                        'name' => 'new_country',
                        'type' => 'text',
                        'label' => 'Új ország',
                        'required' => true,
                        'validation' => 'required|string|max:255',
                        'field_mapping' => 'country'
                    ]
                ],
                'required_documents' => ['address_certificate'],
                'sort_order' => 3
            ],
            [
                'name' => 'bank_details_change',
                'display_name' => 'Bankszámla módosítás',
                'description' => 'Bankszámla adatok megváltoztatása',
                'form_fields' => [
                    [
                        'name' => 'new_bank_account_number',
                        'type' => 'text',
                        'label' => 'Új bankszámlaszám',
                        'required' => true,
                        'validation' => 'required|string|max:50',
                        'field_mapping' => 'bank_account_number'
                    ],
                    [
                        'name' => 'bank_name',
                        'type' => 'text',
                        'label' => 'Bank neve',
                        'required' => true,
                        'validation' => 'required|string|max:255'
                    ]
                ],
                'required_documents' => ['bank_statement'],
                'sort_order' => 4
            ],
            [
                'name' => 'phone_change',
                'display_name' => 'Telefonszám módosítás',
                'description' => 'Telefonszám megváltoztatása',
                'form_fields' => [
                    [
                        'name' => 'new_phone',
                        'type' => 'text',
                        'label' => 'Új telefonszám',
                        'required' => true,
                        'validation' => 'required|string|max:20',
                        'field_mapping' => 'phone',
                        'placeholder' => '+36 30 123 4567'
                    ],
                    [
                        'name' => 'reason',
                        'type' => 'textarea',
                        'label' => 'Módosítás indoka',
                        'required' => false,
                        'validation' => 'nullable|string|max:500'
                    ]
                ],
                'required_documents' => [],
                'sort_order' => 5
            ],
            [
                'name' => 'emergency_contact_change',
                'display_name' => 'Vészhelyzeti kapcsolattartó módosítás',
                'description' => 'Vészhelyzeti kapcsolattartó adatok megváltoztatása',
                'form_fields' => [
                    [
                        'name' => 'new_emergency_contact_name',
                        'type' => 'text',
                        'label' => 'Kapcsolattartó neve',
                        'required' => true,
                        'validation' => 'required|string|max:255',
                        'field_mapping' => 'emergency_contact_name'
                    ],
                    [
                        'name' => 'new_emergency_contact_phone',
                        'type' => 'text',
                        'label' => 'Kapcsolattartó telefonszáma',
                        'required' => true,
                        'validation' => 'required|string|max:20',
                        'field_mapping' => 'emergency_contact_phone',
                        'placeholder' => '+36 30 123 4567'
                    ],
                    [
                        'name' => 'relationship',
                        'type' => 'select',
                        'label' => 'Kapcsolat típusa',
                        'required' => true,
                        'validation' => 'required|string',
                        'options' => [
                            'spouse' => 'Házastárs',
                            'parent' => 'Szülő',
                            'child' => 'Gyermek',
                            'sibling' => 'Testvér',
                            'friend' => 'Barát',
                            'other' => 'Egyéb'
                        ]
                    ]
                ],
                'required_documents' => [],
                'sort_order' => 6
            ]
        ];

        foreach ($dataChangeTypes as $type) {
            DataChangeType::updateOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }
}
