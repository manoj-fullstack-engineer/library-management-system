<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BookIssueReturn;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class BookIssueReturnController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'student_library_id' => 'required|exists:students,student_library_id',
            'book_id'            => 'required|exists:books,id',
            'return_date'        => 'required|date',
            'book_condition'     => 'required|in:Good,Damaged,Lost',
            'fine_amount'        => 'nullable|numeric|min:0',
            'return_remark'      => 'nullable|string|max:1000',
        ]);

        BookIssueReturn::create([
            'student_library_id' => $request->student_library_id,
            'book_id'            => $request->book_id,
            'return_date'        => $request->return_date,
            'book_condition'     => $request->book_condition,
            'fine_amount'        => $request->fine_amount ?? 0,
            'return_remark'      => $request->return_remark,
        ]);

        return back()->with('success', 'Return log saved.');
    }
    public function index(Request $request)
    {
        $query = BookIssueReturn::query();

        // 🔍 Filters
        if ($request->filled('from_date')) {
            $query->whereDate('return_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('return_date', '<=', $request->to_date);
        }

        if ($request->filled('student_library_id')) {
            $query->where('student_library_id', $request->student_library_id);
        }

        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        if ($request->filled('book_condition')) {
            $query->where('book_condition', $request->book_condition);
        }

        // 🔃 Sorting
        $allowedSorts = ['student_library_id', 'book_id', 'return_date', 'book_condition', 'fine_amount'];
        $sort = in_array($request->get('sort'), $allowedSorts) ? $request->get('sort') : 'return_date';
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        $returns = $query
            ->orderBy($sort, $direction)
            ->paginate(15)
            ->appends($request->query());
        $totalFine = (clone $query)->sum('fine_amount');
        return view('backend.book-returns.index', compact('returns', 'totalFine'));

    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected', []);

        if (empty($ids)) {
            return back()->with('error', 'No records selected.');
        }

        BookIssueReturn::whereIn('id', $ids)->delete();

        return back()->with('success', 'Selected records deleted successfully.');
    }

    // In BookIssueReturnController.php



    public function exportPdf(Request $request)
    {
        $query = BookIssueReturn::query();

        // Apply filters if available
        if ($request->filled('from_date')) {
            $query->whereDate('return_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('return_date', '<=', $request->to_date);
        }
        if ($request->filled('student_library_id')) {
            $query->where('student_library_id', $request->student_library_id);
        }
        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }
        if ($request->filled('book_condition')) {
            $query->where('book_condition', $request->book_condition);
        }

        // Optional sorting
        if ($request->filled('sort_by') && $request->filled('order')) {
            $query->orderBy($request->sort_by, $request->order);
        } else {
            $query->latest();
        }

        $returns = $query->get();

        $pdf = Pdf::loadView('backend.book-returns.pdf', compact('returns'))
            ->setPaper('A4', 'landscape');

        $timestamp = now()->format('Ymd_His');
        return $pdf->download("book_return_logs_{$timestamp}.pdf");
    }




    public function print(Request $request)
    {
        $query = BookIssueReturn::query();

        if ($request->filled('from_date')) {
            $query->whereDate('return_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('return_date', '<=', $request->to_date);
        }
        if ($request->filled('student_library_id')) {
            $query->where('student_library_id', $request->student_library_id);
        }
        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }
        if ($request->filled('book_condition')) {
            $query->where('book_condition', $request->book_condition);
        }

        $data = $query->orderByDesc('return_date')->get();

        return view('backend.book-returns.print', compact('data'));
    }

    public function fetchIssueInfo($bookId)
{
    $issue = \App\Models\BookIssue::where('book_id', $bookId)
        ->whereNull('returned_at') // Book must still be issued
        ->with('student:id,student_library_id,name')
        ->first();

    if (!$issue) {
        return response()->json([
            'status' => 'error',
            'message' => 'Book is not currently issued or already returned.'
        ], 404);
    }

    // Fine calculation
    $now = now();
    $dueDate = $issue->due_date ?? $issue->issued_at;
    $daysLate = $now->greaterThan($dueDate) ? $dueDate->diffInDays($now) : 0;
    $finePerDay = 10; // Change if needed
    $fine = $daysLate * $finePerDay;

    return response()->json([
        'status' => 'success',
        'data' => [
            'student_library_id' => $issue->student_library_id,
            'student_name'       => $issue->student->name ?? '',
            'issued_at'          => $issue->issued_at->format('Y-m-d H:i'),
            'due_date'           => optional($issue->due_date)->format('Y-m-d'),
            'is_overdue'         => $daysLate > 0,
            'days_late'          => $daysLate,
            'auto_fine'          => $fine,
        ]
    ]);
}

}
