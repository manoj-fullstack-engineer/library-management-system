<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use App\Models\Category;
use App\Exports\BookExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Drivers\Gd\Driver;


class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view books')->only(['index', 'show']);
        $this->middleware('permission:create books')->only(['create', 'store']);
        $this->middleware('permission:edit books')->only(['edit', 'update']);
        $this->middleware('permission:delete books')->only(['destroy', 'bulkDelete']);
        $this->middleware('permission:export books')->only(['exportExcel', 'exportPdf', 'print']);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'published_from', 'published_to']);

        $query = Book::query()->filter($filters);

        // Sorting
        $sortBy = in_array($request->get('sort_by'), ['title', 'author', 'publisher', 'published_date', 'status'])
            ? $request->get('sort_by')
            : 'id';

        $sortOrder = $request->get('sort_order') === 'asc' ? 'asc' : 'desc';

        // Pagination
        $perPage = in_array($request->per_page, [10, 20, 50, 100, 'all']) ? $request->per_page : 10;

        $books = $perPage === 'all'
            ? $query->orderBy($sortBy, $sortOrder)->get()
            : $query->orderBy($sortBy, $sortOrder)->paginate($perPage)->withQueryString();

        return view('backend.books.index', compact('books', 'filters', 'perPage', 'sortBy', 'sortOrder'));
    }


    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('backend.books.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $validated = $this->validateBook($request);
        $validated['published_date'] = $this->formatDate($validated['published_date'] ?? null);
        $validated['front_cover'] = $this->storeImage($request, 'front_cover');
        $validated['back_cover'] = $this->storeImage($request, 'back_cover');

        Book::create($validated);

        return redirect()->route('backend.books.index')->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        return view('backend.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('backend.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'isbn'          => 'nullable|string|max:255',
            'publisher'     => 'nullable|string|max:255',
            'published_date' => 'nullable|date_format:d/m/Y',
            'category_id'   => 'nullable|exists:categories,id',
            'language'      => 'nullable|string|max:100',
            'pages'         => 'nullable|integer|min:1',
            'status'        => 'required|in:available,issued,damaged,lost',
            'description'   => 'nullable|string|max:1000',
            'front_cover'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'back_cover'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'price'         => 'nullable|numeric|decimal:2',
        ]);

        // Convert date
        if (!empty($validated['published_date'])) {
            $validated['published_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['published_date'])->format('Y-m-d');
        }

        // Handle front cover upload
        if ($request->hasFile('front_cover')) {
            if ($book->front_cover && Storage::exists($book->front_cover)) {
                Storage::delete($book->front_cover);
            }
            $validated['front_cover'] = $request->file('front_cover')->store('books/front_covers', 'public');
        }

        // Handle back cover upload
        if ($request->hasFile('back_cover')) {
            if ($book->back_cover && Storage::exists($book->back_cover)) {
                Storage::delete($book->back_cover);
            }
            $validated['back_cover'] = $request->file('back_cover')->store('books/back_covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('backend.books.index')->with('success', 'Book updated successfully.');
    }


    public function destroy(Book $book)
    {
        $this->deleteImage($book->front_cover);
        $this->deleteImage($book->back_cover);
        $book->delete();

        return response()->json(['success' => 'Book deleted successfully.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['error' => 'No books selected.'], 422);
        }

        $books = Book::whereIn('id', $ids)->get();

        foreach ($books as $book) {
            $this->deleteImage($book->front_cover);
            $this->deleteImage($book->back_cover);
            $book->delete();
        }

        return response()->json(['success' => 'Selected books deleted successfully.']);
    }

    public function exportExcel(Request $request)
    {
        try {
            $filters = $request->only(['search', 'status', 'published_from', 'published_to']);
            $filename = 'books_export_' . now()->format('Ymd_His') . '.xlsx';

            return Excel::download(new BookExport($filters), $filename);
        } catch (\Throwable $e) {
            Log::error('Excel export failed:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Excel export failed.');
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            $books = Book::filter($request->only(['search', 'status', 'published_from', 'published_to']))->get();

            if ($books->isEmpty()) {
                return back()->with('error', 'Books not found.');
            }

            $pdf = Pdf::loadView('backend.books.pdf', compact('books'))->setPaper('a4', 'portrait');
            return $pdf->download('books-report.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'PDF export failed: ' . $e->getMessage());
        }
    }

    public function print(Request $request)
    {
        try {
            $filters = $request->only(['search', 'status', 'published_from', 'published_to']);
            $books = Book::filter($filters)->orderByDesc('published_date')->get();

            if ($books->isEmpty()) {
                return back()->with('error', 'Books not found.');
            }

            return view('backend.books.print', compact('books', 'filters'));
        } catch (\Exception $e) {
            return back()->with('error', 'Print view failed: ' . $e->getMessage());
        }
    }

    // ==== Private Helpers ====

    private function validateBook(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:100',
            'publisher' => 'nullable|string|max:255',
            'published_date' => 'nullable|date_format:d/m/Y',
            'category_id' => 'nullable|exists:categories,id',
            'language' => 'nullable|string|max:100',
            'pages' => 'nullable|integer|min:1',
            'status' => 'required|in:available,issued,damaged,lost',
            'front_cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:102400',
            'back_cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:102400',
            'description' => 'nullable|string|max:5000',
            'price' => 'nullable|numeric|decimal:2',

        ]);
    }

    private function formatDate(?string $date): ?string
    {
        return $date ? \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d') : null;
    }

    private function storeImage(Request $request, string $field): ?string
    {
        if (!$request->hasFile($field)) {
            logger("No file found for {$field}");
            return null;
        }

        $image = $request->file($field);

        logger("Uploaded file {$field} size: " . $image->getSize());

        // TEMPORARILY DISABLE THIS CHECK to avoid blocking large files
        // if ($image->getSize() > 102400) {
        //     logger("Image too large: " . $image->getSize());
        //     return null;
        // }

        $manager = new ImageManager(new Driver());
        $processed = $manager->read($image->getRealPath())->scaleDown(800)->toJpeg(75);

        $filename = 'books/' . time() . '_' . $field . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->put($filename, $processed);

        logger("Image stored: " . $filename);

        return $filename;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function searchByBookId($bookId)
    {
        $book = Book::where('id', $bookId)->first();

        if (!$book) {
            return response('<div class="alert alert-warning">Book not found.</div>', 404);
        }

        // Return only modal content (partial)
        return view('backend.books._modal_show', compact('book'));
    }

    public function modalPreview($bookId)
    {
        $book = Book::where('id', $bookId)->firstOrFail(); // Or use another identifier
        return view('backend.books._modal_show', compact('book'));
    }
    
}
