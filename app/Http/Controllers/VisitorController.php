<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\GenericExport;
use Carbon\Carbon;

class VisitorController extends Controller
{

    public function __construct()
    {
        $this->middleware('visitor:view visitors')->only(['index', 'show']);
        $this->middleware('visitor:create visitors')->only(['create', 'store']);
        $this->middleware('visitor:edit visitors')->only(['edit', 'update']);
        $this->middleware('visitor:delete visitors')->only(['destroy', 'bulkDelete']);
        $this->middleware('visitor:export visitors')->only(['exportExcel', 'exportPdf']);
        $this->middleware('visitor:print visitors')->only(['print']);
    }

  public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Visitor::query();

        return DataTables::of($query)
            ->addColumn('checkbox', fn($v) => '<input type="checkbox" class="rowCheckbox" value="' . $v->id . '">')
            ->addColumn('id', fn($v) => $v->id)
            ->addColumn('name', fn($v) => $v->name ?? '-')
            ->addColumn('email', fn($v) => $v->email ?? '-')
            ->addColumn('phone', fn($v) => $v->phone ?? '-')
            ->addColumn('ip_address', fn($v) => $v->ip_address ?? '-')
            ->addColumn('country', fn($v) => $v->country ?? '-')
            ->addColumn('visited_at', fn($v) => optional($v->visited_at)->format('d/m/Y'))
            ->addColumn('created_at', fn($v) => optional($v->created_at)->format('d/m/Y'))
            ->rawColumns(['checkbox'])
            ->make(true);
    }

    return view('backend.visitors.index');
}


    public function create()
    {
        return view('backend.visitors.create');
    }

    public function store(Request $request)
    {

        $data = $this->validateVisitor($request);
        Visitor::create($data);

        return redirect()->route('backend.visitors.index')->with('success', 'Visitor added successfully.');
    }

    public function edit($id)
    {

        $visitor = Visitor::findOrFail($id);
        return view('backend.visitors.edit', compact('visitor'));
    }

    public function update(Request $request, $id)
    {

        $visitor = Visitor::findOrFail($id);
        $data = $this->validateVisitor($request);
        $visitor->update($data);

        return redirect()->route('backend.visitors.index')->with('success', 'Visitor updated successfully.');
    }

    public function destroy($id)
    {

        Visitor::findOrFail($id)->delete();
        return redirect()->route('backend.visitors.index')->with('success', 'Visitor deleted successfully.');
    }

    public function show($id)
    {

        $visitor = Visitor::findOrFail($id);
        return view('backend.visitors.show', compact('visitor'));
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json(['message' => 'No visitors selected.'], 422);
        }

        Visitor::whereIn('id', $ids)->delete();
        return response()->json(['message' => 'Selected visitors deleted successfully.']);
    }

    public function exportExcel(Request $request)
    {

        $query = $this->buildFilteredQuery($request)->get()->map(function ($visitor) {
            return [
                'Name'       => $visitor->name,
                'Email'      => $visitor->email,
                'Phone'      => $visitor->phone,
                'IP Address' => $visitor->ip_address,
                'Visited At' => optional($visitor->visited_at)->format('d/m/Y'),
                'Created At' => optional($visitor->created_at)->format('d/m/Y'),
            ];
        });

        return Excel::download(new GenericExport($query->toArray()), 'visitors.xlsx');
    }


    public function exportPdf(Request $request)
    {

        $data = $this->getExportData($request);
        $pdf = PDF::loadView('backend.visitors.export_pdf', compact('data'));

        return $pdf->download('visitors.pdf');
    }

    public function print(Request $request)
    {

        $data = $this->getExportData($request);
        return view('backend.visitors.print', compact('data'));
    }

    // ========== Protected Helper Methods ========== //

    protected function buildFilteredQuery(Request $request)
    {
        $query = Visitor::query();

        if ($search = $request->input('search.value') ?? $request->input('search')) {
            $query->where(fn($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('ip_address', 'like', "%{$search}%"));
        }

        if ($request->filled(['date_from', 'date_to'])) {
            $from = Carbon::createFromFormat('d/m/Y', $request->date_from)->startOfDay();
            $to = Carbon::createFromFormat('d/m/Y', $request->date_to)->endOfDay();
            $query->whereBetween('visited_at', [$from, $to]);
        }

        return $query;
    }

    protected function getExportData(Request $request)
    {
        return $this->buildFilteredQuery($request)
            ->orderByDesc('visited_at')
            ->get()
            ->map(fn($v) => [
                'ID' => $v->id,
                'Name' => $v->name,
                'Email' => $v->email,
                'Phone' => $v->phone,
                'IP Address' => $v->ip_address,
                'Visited At' => optional($v->visited_at)->format('d/m/Y'),
                'Created At' => optional($v->created_at)->format('d/m/Y'),
            ])
            ->toArray();
    }

    protected function validateVisitor(Request $request): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'ip_address' => 'nullable|ip',
            'visited_at' => 'required|date_format:d/m/Y',
        ]);

        $validated['visited_at'] = Carbon::createFromFormat('d/m/Y', $validated['visited_at']);
        return $validated;
    }

    protected function authorizeAction(string $permission)
    {
        if (!Auth::user()?->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
