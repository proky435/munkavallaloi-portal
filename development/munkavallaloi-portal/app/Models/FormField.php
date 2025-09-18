<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FormField extends Model
{
    protected $fillable = [
        'name',
        'type',
        'validation_rules',
    ];

    protected $casts = [
        'validation_rules' => 'array',
    ];

    /**
     * Get the categories that use this form field.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_form_field')
                    ->withPivot(['label', 'is_required', 'order', 'field_options'])
                    ->withTimestamps()
                    ->orderBy('pivot_order');
    }

    /**
     * Get validation rules for this field type.
     */
    public function getValidationRulesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Set validation rules for this field type.
     */
    public function setValidationRulesAttribute($value)
    {
        $this->attributes['validation_rules'] = is_array($value) ? json_encode($value) : $value;
    }
}
