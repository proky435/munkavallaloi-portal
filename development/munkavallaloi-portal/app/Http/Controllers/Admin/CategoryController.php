<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FormField;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(): View
    {
        $categories = Category::latest()->get();
        
        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        $formFields = FormField::all();
        
        return view('admin.categories.create', [
            'formFields' => $formFields,
        ]);
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'responsible_email' => 'nullable|email|max:255',
            'form_fields' => 'nullable|array',
            'form_fields.*.field_id' => 'required|exists:form_fields,id',
            'form_fields.*.label' => 'required|string|max:255',
            'form_fields.*.is_required' => 'boolean',
            'form_fields.*.order' => 'required|integer|min:0',
            'form_fields.*.field_options' => 'nullable|array',
        ]);

        DB::transaction(function () use ($validated) {
            $category = Category::create([
                'name' => $validated['name'],
                'responsible_email' => $validated['responsible_email'] ?? null,
            ]);

            if (isset($validated['form_fields'])) {
                foreach ($validated['form_fields'] as $fieldData) {
                    $category->formFields()->attach($fieldData['field_id'], [
                        'label' => $fieldData['label'],
                        'is_required' => $fieldData['is_required'] ?? false,
                        'order' => $fieldData['order'],
                        'field_options' => isset($fieldData['field_options']) ? json_encode($fieldData['field_options']) : null,
                    ]);
                }
            }
        });

        return redirect()->route('admin.categories.index')->with('success', 'Kategória sikeresen létrehozva!');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        $formFields = FormField::all();
        $category->load('formFields');
        
        return view('admin.categories.edit', [
            'category' => $category,
            'formFields' => $formFields,
        ]);
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'responsible_email' => 'nullable|email|max:255',
            'form_fields' => 'nullable|array',
            'form_fields.*.field_id' => 'required|exists:form_fields,id',
            'form_fields.*.label' => 'required|string|max:255',
            'form_fields.*.is_required' => 'boolean',
            'form_fields.*.order' => 'required|integer|min:0',
            'form_fields.*.field_options' => 'nullable|array',
        ]);

        DB::transaction(function () use ($validated, $category) {
            $category->update([
                'name' => $validated['name'],
                'responsible_email' => $validated['responsible_email'] ?? null,
            ]);

            // Detach all existing form fields
            $category->formFields()->detach();

            // Attach new form fields
            if (isset($validated['form_fields'])) {
                foreach ($validated['form_fields'] as $fieldData) {
                    $category->formFields()->attach($fieldData['field_id'], [
                        'label' => $fieldData['label'],
                        'is_required' => $fieldData['is_required'] ?? false,
                        'order' => $fieldData['order'],
                        'field_options' => isset($fieldData['field_options']) ? json_encode($fieldData['field_options']) : null,
                    ]);
                }
            }
        });

        return redirect()->route('admin.categories.index')->with('success', 'Kategória sikeresen frissítve!');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Check if category has tickets
        if ($category->tickets()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'A kategória nem törölhető, mert vannak hozzá tartozó bejelentések!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategória sikeresen törölve!');
    }
}
