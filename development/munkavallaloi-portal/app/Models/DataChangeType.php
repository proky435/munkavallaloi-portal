<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataChangeType extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'form_fields',
        'required_documents',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'form_fields' => 'array',
        'required_documents' => 'array',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('display_name');
    }
}
