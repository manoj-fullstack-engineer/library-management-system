<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\CategoriesExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('view categories');

        $categories = $this->getFilteredCategories($request)->paginate(10);
        return view('backend.categories.index', compact('categories'));
    }

    public function create()
    {
        Gate::authorize('create categories');
        return view('backend.categories.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create categories');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($validated);

        return redirect()->route('backend.categories.index')->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        Gate::authorize('view categories');
        $category = Category::findOrFail($id);
        return view('backend.categories.show', compact('category'));
    }

    public function edit($id)
    {
        Gate::authorize('edit categories');
        $category = Category::findOrFail($id);
        return view('backend.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        Gate::authorize('edit categories');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);
        return redirect()->route('backend.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        Gate::authorize('delete categories');
        $category->delete();
        return redirect()->route('backend.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function exportExcel(Request $request)
    {
        Gate::authorize('view categories');
        $categories = $this->getFilteredCategories($request)->get();
        return Excel::download(new CategoriesExport($categories), 'categories.xlsx');
    }

    public function exportPdf(Request $request)
    {
        Gate::authorize('view categories');
        $categories = $this->getFilteredCategories($request)->get();
        $pdf = Pdf::loadView('backend.categories.pdf', compact('categories'));
        return $pdf->download('categories.pdf');
    }

    public function print(Request $request)
    {
        Gate::authorize('view categories');
        $categories = $this->getFilteredCategories($request)->get();
        return view('backend.categories.print', compact('categories'));
    }

    public function bulkDelete(Request $request)
    {
        Gate::authorize('delete categories');

        $validator = Validator::make($request->all(), [
            'ids' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'No categories selected or invalid request.');
        }

        $idsArray = array_filter(array_map('trim', explode(',', $request->ids)), function ($id) {
            return is_numeric($id);
        });

        if (empty($idsArray)) {
            return redirect()->back()->with('error', 'No valid categories selected.');
        }

        Category::whereIn('id', $idsArray)->delete();

        return redirect()->back()->with('success', 'Selected categories deleted successfully.');
    }

    private function getFilteredCategories(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }

        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = explode(',', $request->ids);
        Category::whereIn('id', $ids)->delete();

        return redirect()->route('backend.categories.index')->with('success', 'Selected categories deleted successfully.');
    }

  
    // Optional private filter method to reuse filtering logic for exports
    private function filterCategories(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Add more filters if you want (date ranges etc.)

        return $query;
    }
}
