<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\InventoryCategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

class InventoryCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $this->applyFilters($request)->latest()->paginate(10);
        return view('backend.inventory-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.inventory-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:inventory_categories,name',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        InventoryCategory::create($validated);

        return redirect()->route('backend.inventory-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function update(Request $request, InventoryCategory $inventoryCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:inventory_categories,name,' . $inventoryCategory->id,
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $inventoryCategory->update($validated);

        return redirect()->route('backend.inventory-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function show(InventoryCategory $inventoryCategory)
    {
        return view('backend.inventory-categories.show', compact('inventoryCategory'));
    }

    public function edit(InventoryCategory $inventoryCategory)
    {
       return view('backend.inventory-categories.edit', compact('inventoryCategory'));

    }


    public function destroy(InventoryCategory $inventoryCategory)
    {
        $inventoryCategory->delete();

        return redirect()->route('backend.inventory-categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function exportPdf(Request $request)
    {
        $categories = $this->applyFilters($request)->get();
        $pdf = Pdf::loadView('backend.inventory-categories.export_pdf', compact('categories'));

        return $pdf->download('inventory-categories.pdf');
    }

    public function exportExcel(Request $request)
    {
        $categories = $this->applyFilters($request)->get();
        return Excel::download(new InventoryCategoriesExport($categories), 'inventory-categories.xlsx');
    }

    public function print(Request $request)
    {
        $categories = $this->applyFilters($request)->get();
        return view('backend.inventory-categories.print', compact('categories'));
    }

    /**
     * Private reusable filter logic for exports and print
     */
    private function applyFilters(Request $request)
    {
        $query = InventoryCategory::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query;
    }
}
