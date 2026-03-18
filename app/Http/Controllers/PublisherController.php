<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Exports\PublishersExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class PublisherController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view publishers')->only(['index', 'show', 'print']);
        $this->middleware('permission:create publishers')->only(['create', 'store']);
        $this->middleware('permission:edit publishers')->only(['edit', 'update']);
        $this->middleware('permission:delete publishers')->only(['destroy', 'bulkDelete']);
        $this->middleware('permission:export publishers')->only(['exportExcel', 'exportPdf']);
    }

    public function index(Request $request)
    {
        $query = Publisher::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%");
            });
        }

        $publishers = $query->orderBy('id', 'desc')->paginate(15);

        return view('backend.publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('backend.publishers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:publishers,email',
            'phone'       => 'nullable|string|max:25',
            'country'     => 'nullable|string|max:100',
            'address'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $validated['logo'] = $this->storeImage($request, 'logo');

        Publisher::create($validated);

        return redirect()->route('backend.publishers.index')->with('success', 'Publisher added successfully.');
    }

    public function show(Publisher $publisher)
    {
        return view('backend.publishers.show', compact('publisher'));
    }

    public function edit(Publisher $publisher)
    {
        return view('backend.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:publishers,email,' . $publisher->id,
            'phone'       => 'nullable|string|max:25',
            'country'     => 'nullable|string|max:100',
            'address'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        if ($request->hasFile('logo')) {
            if ($publisher->logo) {
                Storage::disk('public')->delete($publisher->logo);
            }
            $validated['logo'] = $this->storeImage($request, 'logo');
        }

        $publisher->update($validated);

        return redirect()->route('backend.publishers.index')->with('success', 'Publisher updated successfully.');
    }

    public function destroy(Publisher $publisher)
    {
        if ($publisher->logo) {
            Storage::disk('public')->delete($publisher->logo);
        }

        $publisher->delete();

        return redirect()->route('backend.publishers.index')->with('success', 'Publisher deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);

        $publishers = Publisher::whereIn('id', $request->ids)->get();

        foreach ($publishers as $publisher) {
            if ($publisher->logo) {
                Storage::disk('public')->delete($publisher->logo);
            }
            $publisher->delete();
        }

        return redirect()->route('backend.publishers.index')->with('success', 'Selected publishers deleted successfully.');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PublishersExport($request->search), 'publishers.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $publishers = Publisher::when(
            $request->search,
            fn($q) =>
            $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('phone', 'like', "%{$request->search}%")
                ->orWhere('country', 'like', "%{$request->search}%")
        )->get();

        $pdf = Pdf::loadView('backend.publishers.pdf', compact('publishers'));

        return $pdf->download('publishers.pdf');
    }

    public function print(Request $request)
    {
        $publishers = Publisher::when(
            $request->search,
            fn($q) =>
            $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('phone', 'like', "%{$request->search}%")
                ->orWhere('country', 'like', "%{$request->search}%")
        )->get();

        return view('backend.publishers.print', compact('publishers'));
    }

    private function storeImage(Request $request, string $field): string
{
    if (!$request->hasFile($field)) {
        logger("No file found for {$field}");

        // Define new filename in publishers/ directory
        $filename = 'publishers/' . time() . '_' . $field . '.png';

        // Copy the default.png from root of storage/app/public/ to storage/app/public/publishers/
        Storage::disk('public')->copy('default.png', $filename);

        logger("Default image copied to: " . $filename);
        return $filename;
    }

    $image = $request->file($field);
    logger("Uploaded file {$field} size: " . $image->getSize());

    $manager = new ImageManager(new Driver());
    $processed = $manager->read($image->getRealPath())->scaleDown(800)->toJpeg(75);

    $filename = 'publishers/' . time() . '_' . $field . '.' . $image->getClientOriginalExtension();
    Storage::disk('public')->put($filename, $processed);

    logger("Image stored: " . $filename);
    return $filename;
}

}
