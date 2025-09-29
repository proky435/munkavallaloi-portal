<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DataChangeProcessor;
use App\Models\DataChangeRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FieldMappingController extends Controller
{
    public function index(DataChangeProcessor $processor): View
    {
        // Reload mappings to ensure we have the latest version
        $processor->reloadFieldMappings();
        // Get all unique form fields from existing requests with better structure
        $allFormFields = collect();
        
        DataChangeRequest::whereNotNull('form_data')->get()->each(function($request) use ($allFormFields) {
            if (is_array($request->form_data)) {
                foreach ($request->form_data as $fieldName => $fieldValue) {
                    if (!$allFormFields->contains('name', $fieldName)) {
                        // Ensure sample_value is always a string for display
                        $sampleValue = $fieldValue;
                        if (is_array($sampleValue)) {
                            $sampleValue = json_encode($sampleValue);
                        } elseif (is_null($sampleValue)) {
                            $sampleValue = '';
                        } else {
                            $sampleValue = (string) $sampleValue;
                        }
                        
                        $allFormFields->push([
                            'name' => $fieldName,
                            'sample_value' => $sampleValue,
                            'type' => $this->guessFieldType($fieldValue),
                            'from_request' => $request->id
                        ]);
                    }
                }
            }
        });
        
        $allFormFields = $allFormFields->sortBy('name')->values();
            
        $currentMappings = $processor->getFieldMappings();
        
        // Identify unmapped fields with suggestions
        $unmappedFields = $allFormFields->filter(function($field) use ($currentMappings) {
            $fieldName = is_array($field) ? $field['name'] : $field;
            return !array_key_exists($fieldName, $currentMappings);
        })->map(function($field) {
            $fieldName = is_array($field) ? $field['name'] : $field;
            $sampleValue = is_array($field) ? $field['sample_value'] : '';
            $fieldType = is_array($field) ? $field['type'] : 'unknown';
            
            return [
                'name' => $fieldName,
                'sample_value' => $sampleValue,
                'type' => $fieldType,
                'suggestion' => $this->suggestMapping($fieldName),
                'description' => $this->getFieldDescription($fieldName)
            ];
        });
        
        return view('admin.field-mapping.index', compact('allFormFields', 'currentMappings', 'unmappedFields'));
    }
    
    public function preview(DataChangeRequest $dataChangeRequest, DataChangeProcessor $processor): View
    {
        $formFields = $dataChangeRequest->form_data;
        $currentMappings = $processor->getFieldMappings();
        
        $fieldAnalysis = [];
        foreach ($formFields as $field => $value) {
            $fieldAnalysis[$field] = [
                'value' => $value,
                'current_mapping' => $currentMappings[$field] ?? 'NINCS MAPPING',
                'suggested_mapping' => $this->suggestMapping($field),
                'will_be_applied' => isset($currentMappings[$field]) && $currentMappings[$field] !== null,
            ];
        }
        
        return view('admin.field-mapping.preview', compact('dataChangeRequest', 'fieldAnalysis'));
    }
    
    
    public function update(Request $request)
    {
        $mappings = $request->input('mappings', []);
        
        // Load current mappings from the processor
        $processor = new DataChangeProcessor();
        $processor->reloadFieldMappings();
        $currentMappings = $processor->getFieldMappings();
        
        // Update the mappings
        foreach ($mappings as $field => $mapping) {
            if (empty($mapping)) {
                continue; // Skip empty mappings
            }
            
            if ($mapping === 'null') {
                $currentMappings[$field] = null;
            } else {
                $currentMappings[$field] = $mapping;
            }
        }
        
        // Save the updated mappings to a config file
        $this->saveMappingsToFile($currentMappings);
        
        return redirect()->route('admin.field-mapping.index')
            ->with('success', 'Field mapping-ek sikeresen frissítve!');
    }
    
    public function delete(string $field)
    {
        $processor = new DataChangeProcessor();
        $currentMappings = $processor->getFieldMappings();
        
        unset($currentMappings[$field]);
        
        $this->saveMappingsToFile($currentMappings);
        
        return redirect()->route('admin.field-mapping.index')
            ->with('success', 'Field mapping updated successfully!');
    }
    
    private function getFieldDescription(string $field): string
    {
        $descriptions = [
            // Name fields
            'new_name' => 'Új név megadása',
            'uj_nev' => 'Új név megadása',
            'nev' => 'Név mező',
            'name' => 'Név mező',
            
            // Email fields
            'uj_email' => 'Új email cím',
            'new_email' => 'Új email cím',
            'email' => 'Email cím',
            
            // Phone fields
            'uj_telefon' => 'Új telefonszám',
            'new_phone' => 'Új telefonszám',
            'telefon' => 'Telefonszám',
            'phone' => 'Telefonszám',
            
            // Workplace fields
            'uj_munkahely' => 'Új munkahely kiválasztása',
            'new_workplace' => 'Új munkahely kiválasztása',
            'munkahely' => 'Munkahely',
            'new_workplace_id' => 'Új munkahely ID',
            'uj_munkahely_id' => 'Új munkahely ID',
            
            // Date fields
            'start_date' => 'Munkakezdés dátuma (nem felhasználói adat)',
            'kezdes_datuma' => 'Munkakezdés dátuma (nem felhasználói adat)',
            'date' => 'Dátum mező',
            
            // Other fields
            'reason' => 'Indoklás (nem felhasználói adat)',
            'indoklas' => 'Indoklás (nem felhasználói adat)',
            'indok' => 'Indoklás (nem felhasználói adat)',
            'documents' => 'Dokumentumok (nem felhasználói adat)',
            'megjegyzes' => 'Megjegyzés (nem felhasználói adat)',
        ];
        
        return $descriptions[$field] ?? 'Ismeretlen mező típus';
    }
    
    private function guessFieldType($value): string
    {
        if (is_array($value)) {
            return 'array';
        }
        
        if (is_numeric($value)) {
            return 'number';
        }
        
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        
        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $value)) {
            return 'date';
        }
        
        if (strlen($value) > 100) {
            return 'textarea';
        }
        
        return 'text';
    }
    
    private function suggestMapping(string $field): ?string
    {
        $field = strtolower($field);
        
        // Name fields
        if (str_contains($field, 'new_name') || str_contains($field, 'uj_nev') || $field === 'nev') {
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
        
        // Workplace fields
        if (str_contains($field, 'workplace') || str_contains($field, 'munkahely') || str_contains($field, 'new_workplace_id') || str_contains($field, 'uj_munkahely')) {
            return 'workplace_id';
        }
        
        // Date fields that should be ignored
        if (str_contains($field, 'start_date') || str_contains($field, 'kezdes') || str_contains($field, 'datum')) {
            return null;
        }
        
        // Fields that should be ignored
        if (str_contains($field, 'reason') || str_contains($field, 'indok') || str_contains($field, 'documents') || str_contains($field, 'megjegyzes')) {
            return null;
        }
        
        // Relationship fields (emergency contact relationship)
        if (str_contains($field, 'relationship') || str_contains($field, 'rokonság') || str_contains($field, 'kapcsolat')) {
            return null;
        }
        
        return false; // Unknown field
    }
    
    private function saveMappingsToFile(array $mappings): void
    {
        $configPath = config_path('field_mappings.php');
        
        // Filter out numeric keys and clean the array
        $cleanMappings = [];
        foreach ($mappings as $key => $value) {
            if (!is_numeric($key) && !empty($key)) {
                $cleanMappings[$key] = $value;
            }
        }
        
        // Sort by key for better readability
        ksort($cleanMappings);
        
        $content = "<?php\n\nreturn " . var_export($cleanMappings, true) . ";\n";
        
        file_put_contents($configPath, $content);
        
        // Clear config cache to reload the new mappings
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        
        // Also clear Laravel's config cache
        \Artisan::call('config:clear');
    }
}
