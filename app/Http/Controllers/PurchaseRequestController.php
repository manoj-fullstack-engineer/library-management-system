<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\InventoryCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseRequestExport;

class PurchaseRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:SuperAdmin|Admin|Manager']);
    }

    /** ------------------- Index ------------------- */
    public function index(Request $request)
    {
        $query = $this->buildFilteredQuery($request);
        $purchaseRequests = $query->paginate(10);

        return view('backend.purchase-requests.index', [
            'purchaseRequests' => $purchaseRequests,
            'categories' => InventoryCategory::pluck('name', 'id'),
            'users' => User::pluck('name', 'id'),
            'filters' => $request->only(['item_name', 'requester_id', 'status', 'from_date', 'to_date']),
        ]);
    }

    /** ------------------- Create & Store ------------------- */
    public function create()
    {
        return view('backend.purchase-requests.create', [
            'categories' => InventoryCategory::pluck('name', 'id'),
            'requestData' => null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $validated['request_number'] = 'BEL' . str_pad(PurchaseRequest::max('id') + 1, 5, '0', STR_PAD_LEFT);
        $validated['requested_by'] = Auth::id();

        PurchaseRequest::create($validated);

        return redirect()->route('backend.purchase-requests.index')
            ->with('success', 'Purchase request created successfully.');
    }

    /** ------------------- Show ------------------- */
    public function show(PurchaseRequest $purchaseRequest)
    {
        return view('backend.purchase-requests.show', [
            'purchaseRequest' => $purchaseRequest,
            'requestData' => $purchaseRequest,
            'categories' => InventoryCategory::pluck('name', 'id'),
        ]);
    }

    /** ------------------- Edit & Update ------------------- */
    public function edit(PurchaseRequest $purchaseRequest)
    {
        return view('backend.purchase-requests.edit', [
            'purchaseRequest' => $purchaseRequest,
            'requestData' => $purchaseRequest,
            'categories' => InventoryCategory::pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, PurchaseRequest $purchaseRequest)
    {
        $validated = $this->validateRequest($request);
        $purchaseRequest->update($validated);

        return redirect()->route('backend.purchase-requests.index')
            ->with('success', 'Purchase request updated successfully.');
    }

    /** ------------------- Delete ------------------- */
    public function destroy(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->delete();
        return redirect()->route('backend.purchase-requests.index')
            ->with('success', 'Purchase request deleted successfully.');
    }

    /** ------------------- Export: Print / PDF / Excel ------------------- */
    /** ------------------- Export: Print / PDF / Excel ------------------- */
    public function print(Request $request)
    {
        $purchaseRequests = $this->buildFilteredQuery($request)->get();
        $filters = $this->extractFilters($request);

        $totalItems = $purchaseRequests->count();
        $totalQuantity = $purchaseRequests->sum('quantity');
        $generatedBy = Auth()->user()->name ?? 'System';

        return view('backend.purchase-requests.print', compact(
            'purchaseRequests',
            'filters',
            'totalItems',
            'totalQuantity',
            'generatedBy'
        ));
    }


    public function exportPdf(Request $request)
    {
        $purchaseRequests = $this->buildFilteredQuery($request)->get();
        $filters = $this->extractFilters($request);

        $pdf = PDF::loadView('backend.purchase-requests.export_pdf', compact('purchaseRequests', 'filters'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('purchase_requests.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PurchaseRequestExport($request), 'purchase_requests.xlsx');
    }

    /**Helper method */
    protected function extractFilters(Request $request): array
    {
        return $request->only([
            'item_name',
            'requester_id',
            'status',
            'from_date',
            'to_date',
            'category_id', // optional if your filters include it
        ]);
    }


    /** ------------------- Shared Methods ------------------- */
    protected function buildFilteredQuery(Request $request)
    {
        return PurchaseRequest::with(['category', 'creator'])
            ->when(
                $request->filled('item_name'),
                fn($q) =>
                $q->where('item_name', 'like', '%' . $request->item_name . '%')
            )
            ->when(
                $request->filled('status'),
                fn($q) =>
                $q->where('status', $request->status)
            )
            ->when(
                $request->filled('requester_id'),
                fn($q) =>
                $q->where('requested_by', $request->requester_id)
            )
            ->when(
                $request->filled('from_date'),
                fn($q) =>
                $q->whereDate('created_at', '>=', $request->from_date)
            )
            ->when(
                $request->filled('to_date'),
                fn($q) =>
                $q->whereDate('created_at', '<=', $request->to_date)
            )
            ->latest();
    }

    protected function validateRequest(Request $request): array
    {
        return $request->validate([
            'item_name' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:1',
            'estimated_cost' => 'nullable|numeric|min:0',
            'inventory_category_id' => 'required|exists:inventory_categories,id',
            'remark' => 'nullable|string',
            'status' => 'sometimes|required|in:pending,approved,rejected',
        ]);
    }

    public function approve($id)
    {
        $request = PurchaseRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        return redirect()->back()->with('success', 'Request approved.');
    }

    public function reject($id)
    {
        $request = PurchaseRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return redirect()->back()->with('success', 'Request rejected.');
    }
}
