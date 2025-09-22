<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataChangeType;
use Illuminate\View\View;

class DataChangeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $dataChangeTypes = DataChangeType::orderBy('sort_order')->orderBy('display_name')->get();
        
        return view('admin.data-change-types.index', compact('dataChangeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.data-change-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:data_change_types',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'form_fields' => 'required|json',
            'required_documents' => 'nullable|json',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        DataChangeType::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'form_fields' => json_decode($request->form_fields, true),
            'required_documents' => $request->required_documents ? json_decode($request->required_documents, true) : null,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.data-change-types.index')
            ->with('success', 'Adatváltozás típus sikeresen létrehozva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataChangeType $dataChangeType): View
    {
        return view('admin.data-change-types.show', compact('dataChangeType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataChangeType $dataChangeType): View
    {
        return view('admin.data-change-types.edit', compact('dataChangeType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataChangeType $dataChangeType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:data_change_types,name,' . $dataChangeType->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'form_fields' => 'required|json',
            'required_documents' => 'nullable|json',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $dataChangeType->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'form_fields' => json_decode($request->form_fields, true),
            'required_documents' => $request->required_documents ? json_decode($request->required_documents, true) : null,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.data-change-types.index')
            ->with('success', 'Adatváltozás típus sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataChangeType $dataChangeType)
    {
        $dataChangeType->delete();

        return redirect()->route('admin.data-change-types.index')
            ->with('success', 'Adatváltozás típus sikeresen törölve!');
    }
}
