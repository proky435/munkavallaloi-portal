<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryFormController extends Controller
{
    /**
     * Get the form structure for a specific category.
     */
    public function getForm(Category $category): JsonResponse
    {
        $formFields = $category->formFields()
            ->orderBy('category_form_field.order')
            ->get()
            ->map(function ($field) {
                return [
                    'id' => $field->id,
                    'name' => $field->name,
                    'type' => $field->type,
                    'label' => $field->pivot->label,
                    'is_required' => (bool) $field->pivot->is_required,
                    'order' => $field->pivot->order,
                    'validation_rules' => $field->validation_rules,
                    'field_options' => $field->pivot->field_options ? json_decode($field->pivot->field_options, true) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
            ],
            'form_fields' => $formFields,
        ]);
    }
}
