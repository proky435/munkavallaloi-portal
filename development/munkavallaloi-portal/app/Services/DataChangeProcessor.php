<?php

namespace App\Services;

use App\Models\DataChangeRequest;
use App\Models\User;
use App\Models\Workplace;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataChangeProcessor
{
    /**
     * Field mapping between form fields and User model attributes
     */
    private array $fieldMapping;
    
    public function __construct()
    {
        $this->loadFieldMappings();
    }
    
    private function loadFieldMappings(): void
    {
        // Load from config file if exists, otherwise use default mappings
        $configPath = config_path('field_mappings.php');
        
        if (file_exists($configPath)) {
            $this->fieldMapping = require $configPath;
        } else {
            $this->fieldMapping = $this->getDefaultMappings();
        }
    }
    
    private function getDefaultMappings(): array
    {
        return [
        // Personal Information
        'new_name' => 'name',
        'uj_nev' => 'name',
        'nev' => 'name',
        'name' => 'name',
        
        // Dynamic form fields - common patterns
        'short' => 'name', // rövid szöveg gyakran név
        'rovid' => 'name',
        'rovid_kotelezo' => 'name',
        'r' => 'name', // rövid mező név változáshoz
        
        // Special fields that should be ignored (not mapped to user attributes)
        'reason' => null, // Indoklás - csak a kérésben szerepel
        'documents' => null, // Dokumentumok - külön kezelve
        'indoklas' => null,
        'indok' => null,
        'hosszu' => null, // Hosszú szöveg gyakran indoklás
        'hosszu_kotelezo' => null,
        'h' => null, // hosszú mező indokláshoz
        
        // Date fields that should be ignored (work start dates, etc.)
        'kezdes_datuma' => null,
        'start_date' => null,
        'datum' => null,
        'date' => null,
        
        // Contact Information
        'email' => 'email',
        'uj_email' => 'email',
        'phone' => 'phone',
        'telefon' => 'phone',
        'uj_telefon' => 'phone',
        
        // Personal Data
        'birth_date' => 'birth_date',
        'szuletesi_datum' => 'birth_date',
        'birth_place' => 'birth_place',
        'szuletesi_hely' => 'birth_place',
        
        // Address Information
        'address_street' => 'address_street',
        'utca' => 'address_street',
        'cim_utca' => 'address_street',
        'address_city' => 'address_city',
        'varos' => 'address_city',
        'cim_varos' => 'address_city',
        'address_postal_code' => 'address_postal_code',
        'iranyitoszam' => 'address_postal_code',
        'address_country' => 'address_country',
        'orszag' => 'address_country',
        
        // Financial Information
        'bank_account' => 'bank_account',
        'bankszamla' => 'bank_account',
        'tax_number' => 'tax_number',
        'adoszam' => 'tax_number',
        'social_security_number' => 'social_security_number',
        'taj_szam' => 'social_security_number',
        
        // Emergency Contact
        'emergency_contact_name' => 'emergency_contact_name',
        'sulyossegi_kapcsolat_nev' => 'emergency_contact_name',
        'emergency_contact_phone' => 'emergency_contact_phone',
        'sulyossegi_kapcsolat_telefon' => 'emergency_contact_phone',
        
        // Workplace (special handling)
        'new_workplace_id' => 'workplace_id',
        'uj_munkahely' => 'workplace_id',
        'munkahely' => 'workplace_id',
        'melohely_kotelezo' => 'workplace_id',
        ];
    }

    /**
     * Process an approved data change request
     */
    public function processApprovedRequest(DataChangeRequest $request): array
    {
        if ($request->status !== 'approved') {
            throw new \InvalidArgumentException('Only approved requests can be processed');
        }

        $user = $request->user;
        $changes = [];
        $errors = [];

        DB::beginTransaction();
        
        try {
            // Backup original data
            $originalData = $this->backupUserData($user);
            
            // Process each form field
            foreach ($request->form_data as $formField => $newValue) {
                if (empty($newValue)) {
                    continue; // Skip empty values
                }
                
                // Debug logging
                Log::info('Processing field', [
                    'field' => $formField,
                    'value' => $newValue,
                    'mapping' => $this->fieldMapping[$formField] ?? 'NO_MAPPING'
                ]);
                
                $result = $this->processField($user, $formField, $newValue);
                
                if ($result['success']) {
                    $changes[] = $result;
                } else {
                    $errors[] = $result;
                }
            }
            
            if (empty($errors)) {
                $user->save();
                
                // Create audit trail
                $this->createAuditTrail($request, $originalData, $changes);
                
                // Update request status
                $request->update([
                    'status' => 'completed',
                    'processed_at' => now(),
                    'admin_notes' => ($request->admin_notes ?? '') . "\n\nAdatok sikeresen alkalmazva: " . now()->format('Y-m-d H:i:s')
                ]);
                
                // Clear scheduling if it was scheduled
                if ($request->is_scheduled) {
                    $request->update(['is_scheduled' => false]);
                }
                
                DB::commit();
                
                return [
                    'success' => true,
                    'changes' => $changes,
                    'message' => 'Adatváltozások sikeresen alkalmazva!'
                ];
            } else {
                DB::rollBack();
                
                return [
                    'success' => false,
                    'errors' => $errors,
                    'message' => 'Hiba történt az adatok alkalmazása során.'
                ];
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('DataChangeProcessor error: ' . $e->getMessage(), [
                'request_id' => $request->id,
                'user_id' => $user->id,
                'exception' => $e
            ]);
            
            return [
                'success' => false,
                'errors' => [['field' => 'general', 'error' => $e->getMessage()]],
                'message' => 'Váratlan hiba történt: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process a single field change
     */
    private function processField(User $user, string $formField, $newValue): array
    {
        // Check if we have a mapping for this field
        if (!isset($this->fieldMapping[$formField])) {
            // Try to guess the field mapping based on common patterns
            $guessedMapping = $this->guessFieldMapping($formField);
            if ($guessedMapping !== false) {
                $this->fieldMapping[$formField] = $guessedMapping;
            } else {
                return [
                    'success' => false,
                    'field' => $formField,
                    'error' => 'Ismeretlen mező: ' . $formField . '. Kérjük, adja hozzá a field mapping-hez.'
                ];
            }
        }
        
        $userAttribute = $this->fieldMapping[$formField];
        
        // Skip fields that are mapped to null (like reason, documents)
        if ($userAttribute === null) {
            return [
                'success' => true,
                'field' => $formField,
                'user_attribute' => null,
                'old_value' => null,
                'new_value' => $newValue,
                'change_description' => 'Mező kihagyva: ' . $formField . ' (nem felhasználói adat)'
            ];
        }
        
        $oldValue = $user->getAttribute($userAttribute);
        
        try {
            // Special handling for workplace
            if ($userAttribute === 'workplace_id') {
                return $this->processWorkplaceChange($user, $userAttribute, $newValue, $oldValue);
            }
            
            // Validate the new value
            $validatedValue = $this->validateFieldValue($userAttribute, $newValue);
            
            // Apply the change
            $user->setAttribute($userAttribute, $validatedValue);
            
            return [
                'success' => true,
                'field' => $formField,
                'user_attribute' => $userAttribute,
                'old_value' => $oldValue,
                'new_value' => $validatedValue,
                'change_description' => $this->getChangeDescription($userAttribute, $oldValue, $validatedValue)
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'field' => $formField,
                'error' => 'Hiba a mező feldolgozása során: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Handle workplace changes with validation
     */
    private function processWorkplaceChange(User $user, string $userAttribute, $newValue, $oldValue): array
    {
        // If newValue is numeric, it's a workplace ID
        if (is_numeric($newValue)) {
            $workplace = Workplace::find($newValue);
            if (!$workplace) {
                return [
                    'success' => false,
                    'field' => 'workplace',
                    'error' => 'Érvénytelen munkahely ID: ' . $newValue
                ];
            }
            
            $user->setAttribute($userAttribute, $newValue);
            
            $oldWorkplace = $oldValue ? Workplace::find($oldValue) : null;
            
            return [
                'success' => true,
                'field' => 'workplace',
                'user_attribute' => $userAttribute,
                'old_value' => $oldValue,
                'new_value' => $newValue,
                'change_description' => 'Munkahely: ' . 
                    ($oldWorkplace ? $oldWorkplace->name : 'Nincs') . 
                    ' → ' . $workplace->name
            ];
        }
        
        return [
            'success' => false,
            'field' => 'workplace',
            'error' => 'Érvénytelen munkahely érték: ' . $newValue
        ];
    }

    /**
     * Validate field values based on type
     */
    private function validateFieldValue(string $attribute, $value)
    {
        switch ($attribute) {
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    throw new \InvalidArgumentException('Érvénytelen email cím');
                }
                break;
                
            case 'birth_date':
                try {
                    $date = \Carbon\Carbon::parse($value);
                    if ($date->isFuture()) {
                        throw new \InvalidArgumentException('A születési dátum nem lehet jövőbeli');
                    }
                    return $date->format('Y-m-d');
                } catch (\Exception $e) {
                    throw new \InvalidArgumentException('Érvénytelen dátum formátum: ' . $value);
                }
                
            case 'phone':
                // Basic phone validation
                $cleanPhone = preg_replace('/[^0-9+]/', '', $value);
                if (strlen($cleanPhone) < 8) {
                    throw new \InvalidArgumentException('Érvénytelen telefonszám');
                }
                return $cleanPhone;
                
            case 'tax_number':
                // Hungarian tax number validation (basic)
                $cleanTaxNumber = preg_replace('/[^0-9]/', '', $value);
                if (strlen($cleanTaxNumber) !== 11) {
                    throw new \InvalidArgumentException('Az adószám 11 számjegyből kell álljon');
                }
                return $cleanTaxNumber;
        }
        
        return $value;
    }

    /**
     * Create human-readable change description
     */
    private function getChangeDescription(string $attribute, $oldValue, $newValue): string
    {
        $fieldNames = [
            'name' => 'Név',
            'email' => 'Email',
            'phone' => 'Telefon',
            'birth_date' => 'Születési dátum',
            'birth_place' => 'Születési hely',
            'address_street' => 'Utca, házszám',
            'address_city' => 'Város',
            'address_postal_code' => 'Irányítószám',
            'address_country' => 'Ország',
            'bank_account' => 'Bankszámlaszám',
            'tax_number' => 'Adószám',
            'social_security_number' => 'TAJ szám',
            'emergency_contact_name' => 'Vészhelyzeti kapcsolattartó neve',
            'emergency_contact_phone' => 'Vészhelyzeti kapcsolattartó telefonja',
        ];
        
        $fieldName = $fieldNames[$attribute] ?? $attribute;
        
        return $fieldName . ': ' . ($oldValue ?? 'Nincs') . ' → ' . $newValue;
    }

    /**
     * Backup user data before changes
     */
    private function backupUserData(User $user): array
    {
        return $user->only([
            'name', 'email', 'phone', 'birth_date', 'birth_place',
            'address_street', 'address_city', 'address_postal_code', 'address_country',
            'bank_account', 'tax_number', 'social_security_number',
            'emergency_contact_name', 'emergency_contact_phone', 'workplace_id'
        ]);
    }

    /**
     * Create audit trail entry
     */
    private function createAuditTrail(DataChangeRequest $request, array $originalData, array $changes): void
    {
        // This could be expanded to a separate audit table
        Log::info('Data change applied', [
            'request_id' => $request->id,
            'user_id' => $request->user_id,
            'processed_by' => auth()->id(),
            'original_data' => $originalData,
            'changes' => $changes,
            'timestamp' => now()
        ]);
    }

    /**
     * Try to guess field mapping based on common patterns
     */
    private function guessFieldMapping(string $formField): string|null|false
    {
        $field = strtolower($formField);
        
        // Name related fields
        if (str_contains($field, 'nev') || str_contains($field, 'name') || 
            str_contains($field, 'short') || str_contains($field, 'rovid')) {
            return 'name';
        }
        
        // Email fields
        if (str_contains($field, 'email') || str_contains($field, 'mail')) {
            return 'email';
        }
        
        // Phone fields
        if (str_contains($field, 'phone') || str_contains($field, 'telefon') || str_contains($field, 'tel')) {
            return 'phone';
        }
        
        // Birth date fields (specifically for birth dates)
        if (str_contains($field, 'szulet') || str_contains($field, 'birth')) {
            return 'birth_date';
        }
        
        // Other date fields that should be ignored (like start dates, work dates, etc.)
        if (str_contains($field, 'date') || str_contains($field, 'datum') || 
            str_contains($field, 'kezdes') || str_contains($field, 'start')) {
            return null; // Skip work start dates and other dates
        }
        
        // Workplace fields
        if (str_contains($field, 'workplace') || str_contains($field, 'munkahely') || 
            str_contains($field, 'melohely') || str_contains($field, 'work')) {
            return 'workplace_id';
        }
        
        // Address fields
        if (str_contains($field, 'address') || str_contains($field, 'cim') || str_contains($field, 'utca')) {
            return 'address_street';
        }
        if (str_contains($field, 'city') || str_contains($field, 'varos')) {
            return 'address_city';
        }
        
        // Fields that should be ignored (reason, description, etc.)
        if (str_contains($field, 'reason') || str_contains($field, 'indok') || 
            str_contains($field, 'hosszu') || str_contains($field, 'description') ||
            str_contains($field, 'document') || str_contains($field, 'file') ||
            str_contains($field, 'megjegyzes') || str_contains($field, 'note')) {
            return null;
        }
        
        // If we can't guess, return false
        return false;
    }

    /**
     * Get available field mappings for admin interface
     */
    public function getFieldMappings(): array
    {
        return $this->fieldMapping;
    }
}
