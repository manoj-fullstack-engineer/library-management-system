<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Exports\StockExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InventoryCategory;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Response;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:SuperAdmin|Admin|Manager']);
    }

    public function index(Request $request)
    {
        $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
        ]);

        $query = $this->buildStockQuery($request);
        $stocks = $query->latest()->paginate(10)->withQueryString();
        $categories = InventoryCategory::pluck('name', 'id');

        return view('backend.stocks.index', compact('stocks', 'categories'));
    }

    public function create()
    {
        $categories = InventoryCategory::pluck('name', 'id');
        return view('backend.stocks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_category_id' => 'required|exists:inventory_categories,id',
            'item_name' => 'required|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'remark' => 'nullable|string',
            'bill_file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('bill_file_path')) {
            $validated['bill_file_path'] = $request->file('bill_file_path')->store('private/bills');
        }

        $validated['created_by'] = auth()->id();

        Stock::create($validated);

        return redirect()->route('backend.stocks.index')->with('success', 'Stock entry created successfully.');
    }


    public function edit(Stock $stock)
    {
        $categories = InventoryCategory::pluck('name', 'id');
        return view('backend.stocks.edit', compact('stock', 'categories'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'inventory_category_id' => 'required|exists:inventory_categories,id',
            'item_name' => 'required|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'remark' => 'nullable|string',
            'bill_file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle bill file update
        if ($request->hasFile('bill_file_path')) {
            // Delete old bill file if exists
            if ($stock->bill_file_path && \Storage::disk('local')->exists($stock->bill_file_path)) {
                \Storage::disk('local')->delete($stock->bill_file_path);
            }

            // Store new file
            $validated['bill_file_path'] = $request->file('bill_file_path')->store('private/bills');
        } else {
            // Preserve existing bill file if no new file uploaded
            $validated['bill_file_path'] = $stock->bill_file_path;
        }

        $stock->update($validated);

        return redirect()->route('backend.stocks.index')->with('success', 'Stock entry updated successfully.');
    }



    public function destroy(Stock $stock)
    {
        if ($stock->bill_file_path) {
            Storage::delete($stock->bill_file_path);
        }

        $stock->delete();
        return redirect()->route('backend.stocks.index')->with('success', 'Stock entry deleted successfully.');
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
        ]);

        $filters = $request->only(['search', 'inventory_category_id', 'vendor', 'from', 'to']);
        return Excel::download(new StockExport($filters), 'stocks.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
        ]);

        $stocks = $this->buildStockQuery($request)->latest()->get();
        $user = Auth::user();
        $pdf = Pdf::loadView('backend.stocks.export_pdf', compact('stocks', 'user'));
        return $pdf->download('stock-report.pdf');
    }

    public function print(Request $request)
    {
        $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
        ]);

        $stocks = $this->buildStockQuery($request)->latest()->get();
        return view('backend.stocks.print', compact('stocks'));
    }

    /**
     * Build a filtered query for Stock.
     */
    private function buildStockQuery(Request $request)
    {
        $query = Stock::with(['category', 'creator']);

        if ($request->filled('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('inventory_category_id')) {
            $query->where('inventory_category_id', $request->inventory_category_id);
        }

        if ($request->filled('vendor')) {
            $query->where('vendor', 'like', '%' . $request->vendor . '%');
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        return $query;
    }
    public function show(Stock $stock)
    {
        return view('backend.stocks.show', compact('stock'));
    }




    public function viewBill(Stock $stock)
    {
        if (!$stock->bill_file_path || !Storage::disk('local')->exists($stock->bill_file_path)) {
            abort(404, 'Bill file not found.');
        }

        $mimeType = Storage::disk('local')->mimeType($stock->bill_file_path);
        $fileContent = Storage::disk('local')->get($stock->bill_file_path);

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . basename($stock->bill_file_path) . '"');
    }
}
