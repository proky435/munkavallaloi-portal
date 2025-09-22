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
                        'validation' => 'required|string|max:255'
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
                        'options_source' => 'workplaces'
                    ],
                    [
                        'name' => 'start_date',
                        'type' => 'date',
                        'label' => 'Kezdés dátuma',
                        'required' => true,
                        'validation' => 'required|date|after:today'
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
                        'validation' => 'required|string|max:255'
                    ],
                    [
                        'name' => 'new_city',
                        'type' => 'text',
                        'label' => 'Új város',
                        'required' => true,
                        'validation' => 'required|string|max:255'
                    ],
                    [
                        'name' => 'new_postal_code',
                        'type' => 'text',
                        'label' => 'Új irányítószám',
                        'required' => true,
                        'validation' => 'required|string|max:20'
                    ],
                    [
                        'name' => 'new_country',
                        'type' => 'text',
                        'label' => 'Új ország',
                        'required' => true,
                        'validation' => 'required|string|max:255'
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
                        'validation' => 'required|string|max:50'
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
