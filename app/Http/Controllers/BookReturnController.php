<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Student;
use App\Models\BookIssue;
use App\Models\BookReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookReturnController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:SuperAdmin|Admin|Manager']);
    }

    public function index()
    {
        $returns = BookReturn::latest()->with(['student', 'book'])->paginate(10);
        return view('backend.book-returns.index', compact('returns'));
    }

    public function create()
    {
        $books = Book::all();
        return view('backend.book-returns.create', compact('books'));
    }

public function store(Request $request)
{
    $request->validate([
        'student_library_id' => 'required|exists:students,student_library_id',
        'book_id' => 'required|exists:books,id',
        'issue_date' => 'required|date',
        'return_date' => 'required|date|after_or_equal:issue_date',
        'condition_on_return' => 'nullable|string',
        'remark' => 'nullable|string',
        'fine_amount' => 'nullable|numeric|min:0',
    ]);

    $student = Student::where('student_library_id', $request->student_library_id)->first();
    $book = Book::find($request->book_id);

    if (!$student || !$book) {
        return back()->with('error', 'Student or Book not found.');
    }

    // Calculate fine (fallback if not set manually)
    $dueDate = Carbon::parse($request->issue_date)->addDays(15);
    $returnDate = Carbon::parse($request->return_date);
    $lateDays = $returnDate->gt($dueDate) ? $returnDate->diffInDays($dueDate) : 0;
    $fine = $request->filled('fine_amount') ? $request->fine_amount : ($lateDays * 5);

    // Create Book Return record
    BookReturn::create([
        'student_library_id'   => $student->student_library_id,
        'book_id'              => $book->id,
        'issue_date'           => $request->issue_date,
        'return_date'          => $request->return_date,
        'condition_on_return'  => $request->condition_on_return,
        'fine_amount'          => $fine,
        'remark'               => $request->remark,
        'processed_by'         => auth()->id(),
    ]);

    // Update the book issue: mark as returned
    BookIssue::where('book_id', $book->id)
        ->whereNull('returned_at')
        ->latest()
        ->first()?->update(['returned_at' => now()]);

    // Decrease student's total issued books
    $student->decrement('total_books_issued');

    // Update Book Status based on condition
    $condition = strtolower($request->condition_on_return);
    if ($condition === 'lost') {
        $book->update(['status' => 'lost']);
    } elseif ($condition === 'damaged') {
        $book->update(['status' => 'damaged']);
    } else {
        $book->update(['status' => 'available']);
    }

    // Optional: Send notification to student
    if (!empty($student->email)) {
        Mail::raw(
            "Your book '{$book->title}' has been returned on {$returnDate->toDateString()}. Fine (if any): ₹{$fine}.",
            function ($message) use ($student) {
                $message->to($student->email)->subject('Book Return Confirmation');
            }
        );
    }

    return redirect()->route('backend.book-returns.index')->with('success', 'Book returned successfully.');
}

    public function fetchStudent($libraryId)
    {
        $student = Student::where('student_library_id', $libraryId)->first();

        return $student
            ? response()->json($student)
            : response()->json(['error' => 'Student not found'], 404);
    }

 public function fetchIssueInfo($bookId)
{
    $bookIssue = BookIssue::where('book_id', $bookId)
        ->whereNull('returned_at')
        ->latest()
        ->first();

    if (!$bookIssue) {
        return response()->json(['error' => 'This book is not currently issued or already returned.'], 404);
    }

    $book = $bookIssue->book;
    $student = $bookIssue->student;
    $librarian = $bookIssue->issuedBy;

    return response()->json([
        'book' => [
            'title'  => $book->title ?? 'N/A',
            'status' => $book->status ?? 'N/A',
        ],
        'issued_by' => $librarian->name ?? 'N/A',
        'issue_date' => optional($bookIssue->issued_at)->format('Y-m-d'),
        'due_date' => optional($bookIssue->due_date)->format('Y-m-d'), // ← ADD THIS
        'student' => [
            'student_library_id' => $student->student_library_id ?? '',
            'full_name' => trim("{$student->first_name} {$student->middle_name} {$student->last_name}"),
        ],
    ]);
}


    public function show(BookReturn $bookReturn)
    {
        return view('backend.book-returns.show', compact('bookReturn'));
    }

    public function edit(BookReturn $bookReturn)
    {
        $books = Book::all();
        return view('backend.book-returns.edit', compact('bookReturn', 'books'));
    }

    public function update(Request $request, BookReturn $bookReturn)
    {
        $request->validate([
            'student_library_id' => 'required|exists:students,student_library_id',
            'book_id' => 'required|exists:books,id',
            'issue_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:issue_date',
            'condition_on_return' => 'nullable|string',
            'remark' => 'nullable|string',
        ]);

        $bookReturn->update($request->all());

        return redirect()->route('backend.book-returns.index')->with('success', 'Return updated.');
    }

    public function destroy(BookReturn $bookReturn)
    {
        $bookReturn->delete();
        return redirect()->back()->with('success', 'Return deleted.');
    }
    public function preview($id)
    {
        $return = BookReturn::with(['book', 'librarian', 'student'])->findOrFail($id);
        return view('backend.book-returns._modal_show', compact('return'));
    }
}
