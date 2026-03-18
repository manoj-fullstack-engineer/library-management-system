<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\EnquiriesExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    public function index(Request $request)
{
    $enquiries = $this->getFilteredEnquiries($request)->paginate(10);
    return view('backend.enquiries.index', compact('enquiries'));
}


    public function create()
    {
        return view('backend.enquiries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Enquiry::create($validated);

        return redirect()->route('backend.enquiries.index')->with('success', 'Enquiry submitted successfully.');
    }

    public function show($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('backend.enquiries.show', compact('enquiry'));
    }

    public function edit($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('backend.enquiries.edit', compact('enquiry'));
    }


    public function update(Request $request, Enquiry $enquiry)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        $enquiry->update($validated);
        return redirect()->route('backend.enquiries.index')->with('success', 'Enquiry updated successfully.');
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return redirect()->route('backend.enquiries.index')->with('success', 'Enquiry deleted successfully.');
    }

  public function exportExcel(Request $request)
{
   $enquiries = $this->getFilteredEnquiries($request)->get();
return Excel::download(new EnquiriesExport($enquiries), 'enquiries.xlsx');


}

  public function exportPdf(Request $request)
{
    $enquiries = $this->getFilteredEnquiries($request)->get();
    $pdf = PDF::loadView('backend.enquiries.pdf', compact('enquiries'));
    return $pdf->download('enquiries.pdf');
}

public function print(Request $request)
{
    $enquiries = $this->getFilteredEnquiries($request)->get();
    return view('backend.enquiries.print', compact('enquiries'));
}


private function getFilteredEnquiries(Request $request)
{
    $query = Enquiry::query();

    // Global search
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%')
              ->orWhere('phone', 'like', '%' . $request->search . '%')
              ->orWhere('subject', 'like', '%' . $request->search . '%')
              ->orWhere('status', 'like', '%' . $request->search . '%');
        });
    }

    // Filter by name
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    // Filter by date range
    if ($request->filled('created_from')) {
        $query->whereDate('created_at', '>=', $request->created_from);
    }

    if ($request->filled('created_to')) {
        $query->whereDate('created_at', '<=', $request->created_to);
    }

    return $query->orderBy('created_at', 'desc');
}


    public function bulkDelete(Request $request)
    {
        // Validate that 'ids' is required and is a string
        $validator = Validator::make($request->all(), [
            'ids' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'No enquiries selected or invalid request.');
        }

        // Convert comma-separated string to array and filter non-numeric values
        $idsArray = array_filter(array_map('trim', explode(',', $request->ids)), function ($id) {
            return is_numeric($id);
        });

        if (empty($idsArray)) {
            return redirect()->back()->with('error', 'No valid enquiries selected.');
        }

        // Delete enquiries with validated IDs
        Enquiry::whereIn('id', $idsArray)->delete();

        return redirect()->back()->with('success', 'Selected enquiries deleted successfully.');
    }
}
