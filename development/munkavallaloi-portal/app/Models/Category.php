<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'responsible_email', 'form_type', 'description', 'requires_attachment', 'form_fields'];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the form fields for this category.
     */
    public function formFields(): BelongsToMany
    {
        return $this->belongsToMany(FormField::class, 'category_form_field')
                    ->withPivot(['label', 'is_required', 'order', 'field_options'])
                    ->withTimestamps()
                    ->orderBy('pivot_order');
    }

    /**
     * Get the ordered form fields for this category.
     */
    public function getOrderedFormFields()
    {
        return $this->formFields()->orderBy('category_form_field.order')->get();
    }
}