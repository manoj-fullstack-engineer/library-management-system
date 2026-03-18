<?php

namespace App\Http\Controllers;

use App\Models\InventoryTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryTitleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:SuperAdmin|Admin|Manager']);
    }

    /**
     * Display a listing of the inventory titles.
     */
    public function index()
    {
        $titles = InventoryTitle::latest()->paginate(10);
        return view('backend.inventory-titles.index', compact('titles'));
    }

    /**
     * Show the form for creating a new inventory title.
     */
    public function create()
    {
        return view('backend.inventory-titles.create');
    }

    /**
     * Store a newly created inventory title in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = InventoryTitle::whereRaw('LOWER(name) = ?', [strtolower($value)])->exists();
                    if ($exists) {
                        $fail('The title name has already been taken (case-insensitive).');
                    }
                },
            ],
            'description' => 'nullable|string|max:1000',
        ])->validate();

        InventoryTitle::create($validated);

        return redirect()->route('backend.inventory-titles.index')
            ->with('success', 'Inventory title created successfully.');
    }

    /**
     * Show the form for editing the specified inventory title.
     */
    public function edit(InventoryTitle $inventoryTitle)
    {
        return view('backend.inventory-titles.edit', compact('inventoryTitle'));
    }

    /**
     * Update the specified inventory title in storage.
     */
    public function update(Request $request, InventoryTitle $inventoryTitle)
    {
        $validated = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($inventoryTitle) {
                    $exists = InventoryTitle::whereRaw('LOWER(name) = ?', [strtolower($value)])
                        ->where('id', '!=', $inventoryTitle->id)
                        ->exists();

                    if ($exists) {
                        $fail('The title name has already been taken (case-insensitive).');
                    }
                },
            ],
            'description' => 'nullable|string|max:1000',
        ])->validate();

        $inventoryTitle->update($validated);

        return redirect()->route('backend.inventory-titles.index')
            ->with('success', 'Inventory title updated successfully.');
    }

    /**
     * Remove the specified inventory title from storage.
     */
    public function destroy(InventoryTitle $inventoryTitle)
    {
        $inventoryTitle->delete();

        return redirect()->route('backend.inventory-titles.index')
            ->with('success', 'Inventory title deleted successfully.');
    }
}
