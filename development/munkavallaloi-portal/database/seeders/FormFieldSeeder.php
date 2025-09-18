<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FormField;

class FormFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formFields = [
            [
                'name' => 'Szöveges beviteli mező',
                'type' => 'text',
                'validation_rules' => ['max' => 255]
            ],
            [
                'name' => 'Hosszú szöveges mező',
                'type' => 'textarea',
                'validation_rules' => ['max' => 2000]
            ],
            [
                'name' => 'Legördülő lista',
                'type' => 'select',
                'validation_rules' => []
            ],
            [
                'name' => 'Dátum választó',
                'type' => 'date',
                'validation_rules' => ['date']
            ],
            [
                'name' => 'Fájl feltöltés',
                'type' => 'file',
                'validation_rules' => ['mimes' => 'pdf,doc,docx,jpg,jpeg,png', 'max' => 10240]
            ],
            [
                'name' => 'Jelölőnégyzet',
                'type' => 'checkbox',
                'validation_rules' => []
            ],
            [
                'name' => 'E-mail cím',
                'type' => 'email',
                'validation_rules' => ['email', 'max' => 255]
            ],
            [
                'name' => 'Telefonszám',
                'type' => 'tel',
                'validation_rules' => ['max' => 20]
            ],
            [
                'name' => 'Szám',
                'type' => 'number',
                'validation_rules' => ['numeric']
            ],
            [
                'name' => 'Pénzösszeg',
                'type' => 'currency',
                'validation_rules' => ['numeric', 'min' => 0]
            ]
        ];

        foreach ($formFields as $field) {
            FormField::create($field);
        }
    }
}
