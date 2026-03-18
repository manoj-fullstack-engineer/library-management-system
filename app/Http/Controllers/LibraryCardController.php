<?php

namespace App\Http\Controllers;

use App\Models\LibraryCard;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\LibraryCardPdfMail;


class LibraryCardController extends Controller
{
    public function index(Request $request)
    {
        $query = LibraryCard::with('student');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('student_library_id', 'like', "%{$search}%");
            });
        }

        $libraryCards = $query->latest()->paginate(10)->withQueryString();

        return view('backend.library-cards.index', compact('libraryCards'));
    }


    public function create()
    {
        $students = Student::all();
        return view('backend.library-cards.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::findOrFail($request->student_id);

        // Increment issued count
        $existingCard = LibraryCard::where('student_id', $student->id)->latest()->first();
        $issuedCount = $existingCard ? $existingCard->issued_count + 1 : 1;

        $card = LibraryCard::create([
            'student_id'  => $student->id,
            'card_number' => 'CARD-' . strtoupper(uniqid()),
            'issued_count' => $issuedCount,
            'issued_on' => now(),
            'issued_by' => auth()->user()->name ?? 'System',
        ]);

        return redirect()->route('backend.library-cards.index')->with('success', 'Library card issued.');
    }

    public function show(LibraryCard $libraryCard)
    {
        return view('backend.library-cards.show', compact('libraryCard'));
    }

    public function destroy(LibraryCard $libraryCard)
    {
        $libraryCard->delete();
        return back()->with('success', 'Library card deleted.');
    }

    public function print(LibraryCard $libraryCard)
    {
        return view('backend.library-cards.print', compact('libraryCard'));
    }


    public function exportPdf($id)
    {
        // ✅ Load the LibraryCard with related student
        $libraryCard = LibraryCard::with('student')->findOrFail($id);

        // ✅ Generate the PDF using the correct view
        $pdf = Pdf::loadView('backend.library-cards.export-pdf', compact('libraryCard'));

        return $pdf->download('library-card-' . $libraryCard->card_number . '.pdf');
    }

   public function sendPdf($id)
{
    $libraryCard = LibraryCard::with('student')->findOrFail($id);

    // Generate PDF from view
    $pdf = Pdf::loadView('backend.library-cards.export-pdf', ['libraryCard' => $libraryCard]);

    $recipient = $libraryCard->student->email;

    if ($recipient) {
        Mail::to($recipient)->send(new LibraryCardPdfMail($libraryCard, $pdf->output()));
        return back()->with('success', 'Library Card PDF emailed successfully!');
    }

    return back()->with('error', 'Student email not found.');
}

}
