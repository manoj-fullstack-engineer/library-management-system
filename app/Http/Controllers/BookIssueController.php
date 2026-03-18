<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Student;
use App\Models\BookIssue;
use App\Mail\BookIssuedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookIssuesExport;
use Illuminate\Support\Facades\Auth;

class BookIssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view book-issues')->only(['index', 'show', 'print']);
        $this->middleware('permission:create book-issues')->only(['create', 'store']);
        $this->middleware('permission:edit book-issues')->only(['edit', 'update']);
        $this->middleware('permission:delete book-issues')->only(['destroy', 'bulkDelete']);
        $this->middleware('permission:export book-issues')->only(['exportExcel', 'exportPdf']);
    }

    public function index(Request $request)
    {
        $query = BookIssue::with(['student', 'book', 'issuer']);

        if ($request->filled('search')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                    ->orWhere('last_name', 'like', "%{$request->search}%")
                    ->orWhere('student_library_id', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('from')) {
            $query->whereDate('due_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('due_date', '<=', $request->to);
        }

        $perPage = $request->get('per_page', 10);
        $bookIssues = $perPage === 'all'
            ? $query->orderByDesc('id')->get()
            : $query->orderByDesc('id')->paginate($perPage)->withQueryString();

        return view('backend.book-issues.index', compact('bookIssues'));
    }

    public function create()
    {
        return view('backend.book-issues.create', [
            'bookIssue' => null
        ]);
    }

    public function store(Request $request)
    {
        // Step 1: Validate request
        $validated = Validator::make($request->all(), [
            'student_library_id' => 'required|exists:students,student_library_id',
            'book_id'            => 'required|exists:books,id',
            'book_condition'     => 'nullable|string|max:255',
            'due_date'           => 'required|date|after_or_equal:today',
            'remark'             => 'nullable|string|max:1000',
        ])->validate();

        // Step 2: Fetch student
        $student = Student::where('student_library_id', $validated['student_library_id'])->first();

        if (!$student) {
            return redirect()->back()->withInput()->withErrors(['student_library_id' => 'Student not found.']);
        }

        // Step 3: Membership and blacklist checks
        if (strtolower($student->membership_status) !== 'active') {
            return redirect()->back()->withInput()->withErrors([
                'student_library_id' => 'Membership status is not active.'
            ]);
        }

        if ($student->blacklist_status == 1) {
            return redirect()->back()->withInput()->withErrors([
                'student_library_id' => 'Student is blacklisted.'
            ]);
        }

        // Step 4: Check book limit
        if ($student->total_books_issued >= $student->max_book_limit) {
            return redirect()->back()->withInput()->withErrors([
                'student_library_id' => 'You already have the maximum limit of books issued.'
            ]);
        }

        // Step 5: Fetch book and check its status
        $book = Book::find($validated['book_id']);
        if (!$book || !in_array(strtolower($book->status), ['available', 'damaged'])) {
            return redirect()->back()->withInput()->withErrors([
                'book_id' => 'The book is either issued or lost.'
            ]);
        }

        // Step 6: Calculate additional fields
        $currentIssuedCount = BookIssue::where('student_library_id', $student->student_library_id)->count();
        $bookStatusSnapshot = $book->status;

        // Step 7: Create BookIssue record
        $bookIssue = BookIssue::create([
            'student_library_id'      => $validated['student_library_id'],
            'book_id'                 => $validated['book_id'],
            'due_date'                => $validated['due_date'],
            'remark'                  => $validated['remark'],
            'issued_at'               => now(),
            'issued_by'               => Auth::id(),
            'total_issued_book_count' => $currentIssuedCount + 1,
            'book_status'             => 'issued',
            'book_condition'          => $validated['book_condition'] ?? null,
        ]);

        // Step 8: Update book status to 'issued'
        $book->status = 'issued';
        $book->save();

        // Step 9: Increment student's issued book count
        $student->increment('total_books_issued');

        // Step 10: Send email (non-blocking)
        if ($student->email) {
            Mail::to($student->email)->queue(new BookIssuedMail($bookIssue));
        }

        return redirect()->route('backend.book-issues.index')
            ->with('success', 'Book issued successfully.');
    }




    public function show(BookIssue $book_issue)
    {
        return view('backend.book-issues.show', compact('book_issue'));
    }

    public function edit(BookIssue $bookIssue)
    {
        return view('backend.book-issues.edit', compact('bookIssue'));
    }

public function update(Request $request, BookIssue $bookIssue)
{
    // Step 1: Validate only selected fields
    $validated = Validator::make($request->all(), [
        'due_date'       => 'required|date|after_or_equal:today',
        'remark'         => 'nullable|string|max:1000',
        'book_condition' => 'nullable|string|max:255',
    ])->validate();

    // Step 2: Update BookIssue record
    $bookIssue->update($validated);

    // Step 3: Redirect with success
    return redirect()->route('backend.book-issues.index')
        ->with('success', 'Book issue updated successfully.');
}




    public function destroy(BookIssue $book_issue)
    {
        $book_issue->delete();
        return redirect()->route('backend.book-issues.index')->with('success', 'Book issue deleted successfully.');
    }



    public function exportExcel(Request $request)
    {
        return Excel::download(
            new BookIssuesExport($request->search, $request->from, $request->to),
            'book-issues.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $bookIssues = BookIssue::with(['student', 'book'])
            ->when($request->search, fn($q) => $q->whereHas('student', fn($q2) => $q2->where('first_name', 'like', "%{$request->search}%")))
            ->when($request->from, fn($q) => $q->whereDate('due_date', '>=', $request->from))
            ->when($request->to, fn($q) => $q->whereDate('due_date', '<=', $request->to))
            ->get();

        $pdf = Pdf::loadView('backend.book-issues.pdf', compact('bookIssues'));
        return $pdf->download('book-issues.pdf');
    }

    public function print(Request $request)
    {
        $bookIssues = BookIssue::with(['student', 'book'])
            ->when($request->search, fn($q) => $q->whereHas('student', fn($q2) => $q2->where('first_name', 'like', "%{$request->search}%")))
            ->when($request->from, fn($q) => $q->whereDate('due_date', '>=', $request->from))
            ->when($request->to, fn($q) => $q->whereDate('due_date', '<=', $request->to))
            ->get();

        return view('backend.book-issues.print', compact('bookIssues'));
    }

    public function previewStudentByLibraryId($libraryId)
    {
        $student = Student::where('student_library_id', $libraryId)->first();

        if (!$student) {
            return response('<div class="alert alert-warning">❌ Student not found.</div>', 404);
        }

        return view('backend.students._modal_show', compact('student'));
    }


    // Show return form
    public function returnForm($id)
    {
        $bookIssue = BookIssue::findOrFail($id);
        return view('backend.book-issues.return', compact('bookIssue'));
    }

    // Process return
    public function returnUpdate($id)
    {
        $bookIssue = BookIssue::findOrFail($id);

        if ($bookIssue->returned_at) {
            return redirect()->route('backend.book-issues.index')->with('info', 'Book already returned.');
        }

        $bookIssue->update(['returned_at' => now()]);

        $bookIssue->book->update(['status' => 'available']);

        $bookIssue->student?->decrement('total_books_issued');

        return redirect()->route('backend.book-issues.index')->with('success', 'Book returned successfully.');
    }

    public function bulkReturn(Request $request)
    {
        $issueIds = $request->input('issue_ids', []);

        foreach ($issueIds as $id) {
            $issue = BookIssue::find($id);

            if ($issue && !$issue->returned_at) {
                $issue->returned_at = now();
                $issue->save();

                // Update book status
                $issue->book->status = 'available';
                $issue->book->save();

                // Decrement student's count if needed
                $issue->student->decrement('total_books_issued');
            }
        }

        return redirect()->back()->with('success', 'Selected books marked as returned.');
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('issue_ids', []);

        if (!empty($ids)) {
            BookIssue::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Selected issues deleted.');
        }

        return redirect()->back()->with('warning', 'No issues selected for deletion.');
    }
    public function previewIssueByBook($bookId)
    {
        // Fetch the most recent issued record for this book
        $bookIssue = BookIssue::with(['student', 'book'])
            ->where('book_id', $bookId)
            ->whereNull('returned_at') // Still issued
            ->latest('issued_at')
            ->first();


        if (!$bookIssue) {
            return response()->json([
                'status' => 'error',
                'message' => 'No active issue found for this book.',
            ]);
        }

        $html = view('backend.book-issues._partial_issue_preview', compact('bookIssue'))->render();

        $student = Student::where('student_library_id', $bookIssue->student_library_id)->first();
        $studentName = collect([
            $bookIssue->student->first_name,
            $bookIssue->student->middle_name,
            $bookIssue->student->last_name,
        ])->filter()->implode(' ');



        return response()->json([
            'status' => 'success',
            'student_name' => $studentName,
            'html' => $html,
        ]);
    }
}
