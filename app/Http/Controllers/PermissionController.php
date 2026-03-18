<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Exports\FilteredPermissionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $this->validateDateRange($request);

        $query = $this->filterPermissions($request); // should return a query builder

        $perPage = $request->get('per_page', 10);

        if ($perPage === 'all') {
            // For 'all', use a very large number so paginate returns all records
            $perPage = 1000000;
        } else {
            $perPage = (int) $perPage;
        }

        $permissions = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('backend.permissions.index', compact('permissions'));
    }



    public function create()
    {
        return view('backend.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()->route('backend.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.permissions.show', compact('permission'));
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('backend.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('backend.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_permissions' => 'required|array',
            'selected_permissions.*' => 'exists:permissions,id',
        ]);

        Permission::whereIn('id', $request->selected_permissions)->delete();

        if ($request->ajax()) {
            return response()->json(['message' => 'Selected permissions deleted successfully.']);
        }

        return redirect()->route('backend.permissions.index')
            ->with('success', 'Selected permissions deleted successfully.');
    }

    public function exportPdf()
    {
        $permissions = Permission::latest()->get();
        $pdf = Pdf::loadView('backend.permissions.export_pdf', compact('permissions'));
        return $pdf->download('permissions_all_' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new FilteredPermissionsExport([]), 'permissions_all_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportFilteredPDF(Request $request)
    {
        $this->validateDateRange($request);

        $permissions = $this->filterPermissions($request)->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('backend.permissions.export_pdf', compact('permissions'));
        return $pdf->download('permissions_filtered_' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportFilteredExcel(Request $request)
    {
        $this->validateDateRange($request);

        $filters = [
            'search' => $request->search,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        return Excel::download(new FilteredPermissionsExport($filters), 'permissions_filtered_' . now()->format('Ymd_His') . '.xlsx');
    }

    /**
     * Validate date range format for requests
     */
    protected function validateDateRange(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date_format:d/m/Y',
            'end_date' => 'nullable|date_format:d/m/Y|after_or_equal:start_date',
        ]);
    }

    /**
     * Filter permissions based on query parameters
     */
    protected function filterPermissions(Request $request)
    {
        $query = Permission::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('start_date')) {
            $startDate = $this->parseDate($request->start_date);
            if ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }
        }

        if ($request->filled('end_date')) {
            $endDate = $this->parseDate($request->end_date, false);
            if ($endDate) {
                $query->where('created_at', '<=', $endDate);
            }
        }

        return $query;
    }

    /**
     * Parse date in d/m/Y format
     */
    protected function parseDate($date, $startOfDay = true)
    {
        try {
            $carbon = Carbon::createFromFormat('d/m/Y', $date);
            return $startOfDay ? $carbon->startOfDay() : $carbon->endOfDay();
        } catch (\Exception $e) {
            return null;
        }
    }
}
