<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Exports\AuthorsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class AuthorController extends Controller
{
    public function __construct()
    {
        // Assign permissions for each action
        $this->middleware('permission:view authors')->only(['index', 'show', 'print']);
        $this->middleware('permission:create authors')->only(['create', 'store']);
        $this->middleware('permission:edit authors')->only(['edit', 'update']);
        $this->middleware('permission:delete authors')->only(['destroy', 'bulkDelete']);
        $this->middleware('permission:export authors')->only(['exportExcel', 'exportPdf']);
    }

    public function index(Request $request)
    {
        $query = Author::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        $authors = $query->orderBy('id', 'desc')->paginate(15);

        return view('backend.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('backend.authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:authors,email',
            'phone'     => 'nullable|string|max:25',
            'country'   => 'nullable|string|max:100',
            'biography' => 'nullable|string',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $validated['photo'] = $this->storeImage($request, 'photo');

        Author::create($validated);

        return redirect()->route('backend.authors.index')->with('success', 'Author added successfully.');
    }

    public function show(Author $author)
    {
        return view('backend.authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('backend.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:authors,email,' . $author->id,
            'phone'     => 'nullable|string|max:25',
            'country'   => 'nullable|string|max:100',
            'biography' => 'nullable|string',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        if ($request->hasFile('photo')) {
            if ($author->photo) {
                Storage::disk('public')->delete($author->photo);
            }
            $validated['photo'] = $this->storeImage($request, 'photo');
        }

        $author->update($validated);

        return redirect()->route('backend.authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        if ($author->photo) {
            Storage::disk('public')->delete($author->photo);
        }

        $author->delete();

        return redirect()->route('backend.authors.index')->with('success', 'Author deleted successfully.');
    }

   public function bulkDelete(Request $request)
{
    Log::debug('Bulk delete called', $request->all());

    $request->validate(['ids' => 'required|array']);

    $authors = Author::whereIn('id', $request->ids)->get();

    foreach ($authors as $author) {
        if ($author->photo) {
            Storage::disk('public')->delete($author->photo);
        }
        $author->delete();
    }

    return redirect()->route('backend.authors.index')->with('success', 'Selected authors deleted successfully.');
}


    public function exportExcel(Request $request)
    {
        return Excel::download(new AuthorsExport($request->search), 'authors.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $authors = Author::when($request->search, fn($q) =>
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%')
              ->orWhere('phone', 'like', '%' . $request->search . '%')
              ->orWhere('country', 'like', '%' . $request->search . '%')
        )->get();

        $pdf = Pdf::loadView('backend.authors.pdf', compact('authors'));

        return $pdf->download('authors.pdf');
    }

    public function print(Request $request)
    {
        $authors = Author::when($request->search, fn($q) =>
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%')
              ->orWhere('phone', 'like', '%' . $request->search . '%')
              ->orWhere('country', 'like', '%' . $request->search . '%')
        )->get();

        return view('backend.authors.print', compact('authors'));
    }

    private function storeImage(Request $request, string $field): ?string
    {
        if (!$request->hasFile($field)) {
            logger("No file found for {$field}");
            return null;
        }

        $image = $request->file($field);

        logger("Uploaded file {$field} size: " . $image->getSize());

        $manager = new ImageManager(new Driver());
        $processed = $manager->read($image->getRealPath())
                             ->scaleDown(800)
                             ->toJpeg(75);

        $filename = 'authors/' . time() . '_' . $field . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->put($filename, $processed);

        logger("Image stored: " . $filename);

        return $filename;
    }
}
