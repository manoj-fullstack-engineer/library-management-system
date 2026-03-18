<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Mail\StudentEnrolledMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;



class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view students')->only(['index', 'show', 'print']);
        $this->middleware('permission:create students')->only(['create', 'store']);
        $this->middleware('permission:edit students')->only(['edit', 'update']);
        $this->middleware('permission:delete students')->only(['destroy', 'bulkDelete']);
        $this->middleware('permission:export students')->only(['exportExcel', 'exportPdf']);
    }

    // INDEX
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('course', 'like', '%' . $request->search . '%')
                    ->orWhere('enrollment_no', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('from')) {
            // Assume $request->from is Y-m-d or convert if needed
            $query->whereDate('enrollment_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            // Assume $request->to is Y-m-d or convert if needed
            $query->whereDate('enrollment_date', '<=', $request->to);
        }

        $perPage = $request->get('per_page', 10);
        if ($perPage === 'all') {
            $students = $query->orderByDesc('id')->get(); // No pagination
        } else {
            $students = $query->orderByDesc('id')->paginate((int) $perPage)->withQueryString();
        }

        return view('backend.students.index', compact('students'));
    }

    // CREATE
    public function create()
    {
        return view('backend.students.create');
    }

    // STORE





    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255|unique:students,email',
                'contact_number' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
                'gender' => 'nullable|in:male,female,other',
                'address' => 'nullable|string|max:1000',
                'enrollment_no' => 'nullable|string|max:255',
                'student_library_id' => 'required|unique:students,student_library_id',
                'department' => 'nullable|string|max:255',
                'course' => 'nullable|string|max:255',
                'year_semester' => 'nullable|string|max:255',
                'membership_status' => 'nullable|in:Active,Inactive,Suspended',
                'blacklist_status' => 'nullable|in:0,1',
                'enrollment_date' => 'nullable|date',
                'total_books_issued' => 'nullable|integer|min:0',
                'max_book_limit' => 'nullable|integer|min:1|max:10',
                'fine_amount' => 'nullable|numeric|min:0',
                'password' => 'nullable|string|min:6|max:255',
                'last_login' => 'nullable|date',
                'remark' => 'nullable|string|max:1000',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'compressed_photo' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $message = 'Record could not be saved.';

                if ($errors->has('email')) {
                    $message = 'Duplicate Email ID entered.';
                } elseif ($errors->has('student_library_id')) {
                    $message = 'Duplicate or Missing Library ID.';
                }

                return back()->withErrors($validator)->withInput()->with('error', $message);
            }

            $student = new Student([
                'student_library_id'=> $request->student_library_id, 
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'address' => $request->address,
                'enrollment_no' => $request->enrollment_no,
                'department' => $request->department,
                'course' => $request->course,
                'year_semester' => $request->year_semester,
                'membership_status' => $request->membership_status,
                'blacklist_status' => $request->blacklist_status,
                'enrollment_date' => $request->enrollment_date,
                'total_books_issued' => $request->total_books_issued ?? 0,
                'max_book_limit' => $request->max_book_limit ?? 3,
                'fine_amount' => $request->fine_amount ?? 0,
                'remark' => $request->remark,
                'last_login' => $request->last_login,
            ]);

            if ($request->filled('password')) {
                $student->password = bcrypt($request->password);
            }

            // Handle compressed photo (base64)
            if ($request->filled('compressed_photo')) {
                $image_parts = explode(";base64,", $request->compressed_photo);
                if (count($image_parts) === 2) {
                    $image_base64 = base64_decode($image_parts[1]);
                    $filename = uniqid('student_') . '.jpg';
                    $path = storage_path('app/public/students');
                    if (!file_exists($path)) mkdir($path, 0755, true);
                    file_put_contents($path . '/' . $filename, $image_base64);
                    $student->photo = 'students/' . $filename;
                }
            } elseif ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = uniqid('student_') . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('students', $filename, 'public');
                $student->photo = $filePath;
            }

            $student->save();

            return redirect()->route('backend.students.index')->with('success', 'Student created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Record could not be saved due to a system error.');
        }
    }



    // SHOW
    public function show(Student $student)
    {
        return view('backend.students.show', compact('student'));
    }

    // EDIT
    public function edit(Student $student)
    {
        return view('backend.students.edit', compact('student'));
    }

    // UPDATE

    public function update(Request $request, Student $student)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255|unique:students,email,' . $student->id,
                'contact_number' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
                'gender' => 'nullable|in:male,female,other',
                'address' => 'nullable|string|max:1000',
                'enrollment_no' => 'nullable|string|max:255',
                'student_library_id' => 'required|string|unique:students,student_library_id,' . $student->id,
                'department' => 'nullable|string|max:255',
                'course' => 'nullable|string|max:255',
                'year_semester' => 'nullable|string|max:255',
                'membership_status' => 'nullable|in:Active,Inactive,Suspended',
                'blacklist_status' => 'nullable|in:0,1',
                'enrollment_date' => 'nullable|date',
                'total_books_issued' => 'nullable|integer|min:0',
                'max_book_limit' => 'nullable|integer|min:1|max:10',
                'fine_amount' => 'nullable|numeric|min:0',
                'password' => 'nullable|string|min:6|max:255',
                'last_login' => 'nullable|date',
                'remark' => 'nullable|string|max:1000',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'compressed_photo' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $message = 'Record could not be updated.';

                if ($errors->has('email')) {
                    $message = 'Duplicate Email ID entered.';
                } elseif ($errors->has('student_library_id')) {
                    $message = 'Duplicate or Missing Library ID.';
                }

                return back()->withErrors($validator)->withInput()->with('error', $message);
            }

            $student->fill([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'address' => $request->address,
                'enrollment_no' => $request->enrollment_no,
                'student_library_id' => $request->student_library_id,
                'department' => $request->department,
                'course' => $request->course,
                'year_semester' => $request->year_semester,
                'membership_status' => $request->membership_status,
                'blacklist_status' => $request->blacklist_status,
                'enrollment_date' => $request->enrollment_date,
                'total_books_issued' => $request->total_books_issued ?? 0,
                'max_book_limit' => $request->max_book_limit ?? 3,
                'fine_amount' => $request->fine_amount ?? 0,
                'remark' => $request->remark,
                'last_login' => $request->last_login,
            ]);

            if ($request->filled('password')) {
                $student->password = bcrypt($request->password);
            }

            // Handle compressed base64 image
            if ($request->filled('compressed_photo')) {
                $image_parts = explode(";base64,", $request->compressed_photo);
                if (count($image_parts) === 2) {
                    $image_base64 = base64_decode($image_parts[1]);
                    $filename = uniqid('student_') . '.jpg';
                    $path = storage_path('app/public/students');
                    if (!file_exists($path)) mkdir($path, 0755, true);
                    file_put_contents($path . '/' . $filename, $image_base64);

                    // Optionally delete old photo
                    if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                        Storage::disk('public')->delete($student->photo);
                    }

                    $student->photo = 'students/' . $filename;
                }
            } elseif ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = uniqid('student_') . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('students', $filename, 'public');

                // Optionally delete old photo
                if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                    Storage::disk('public')->delete($student->photo);
                }

                $student->photo = $filePath;
            }

            $student->save();

            return redirect()->route('backend.students.index')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Record could not be updated due to a system error.');
        }
    }



    // DESTROY
    public function destroy(Student $student)
    {
        if ($student->photo && Storage::disk('public')->exists($student->photo)) {
            Storage::disk('public')->delete($student->photo);
        }
        $student->delete();

        return to_route('backend.students.index')->with('success', 'Student deleted successfully.');
    }

    // BULK DELETE
    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);

        Student::whereIn('id', $request->ids)->each(function ($student) {
            if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                Storage::disk('public')->delete($student->photo);
            }
            $student->delete();
        });

        return to_route('backend.students.index')->with('success', 'Selected students deleted successfully.');
    }

    // EXPORT
    public function exportExcel(Request $request)
    {
        return Excel::download(new StudentsExport($request->search), 'students.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $students = Student::query()
            ->when($request->search, fn($q) => $this->applySearch($q, $request->search))
            ->get();

        $pdf = Pdf::loadView('backend.students.pdf', compact('students'));

        return $pdf->download('students.pdf');
    }

    public function print(Request $request)
    {
        $students = Student::query()
            ->when($request->search, fn($q) => $this->applySearch($q, $request->search))
            ->get();

        return view('backend.students.print', compact('students'));
    }

    // PRIVATE HELPERS

    private function applySearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('registration_number', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('middle_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%")
                ->orWhere('department', 'like', "%{$search}%")
                ->orWhere('course', 'like', "%{$search}%")
                ->orWhere('library_card_number', 'like', "%{$search}%");
        });
    }

    /**
     * Validate data for both store and update.
     * Accepts $id for unique rule exceptions in update.
     */
    private function validateData(Request $request, $id = null): array
    {
        $rules = [
            'first_name'         => ['required', 'string', 'max:255'],
            'middle_name'        => ['nullable', 'string', 'max:255'],
            'last_name'          => ['required', 'string', 'max:255'],
            'email'              => ['nullable', 'email', 'max:255', 'unique:students,email,' . $id],
            'contact_number'     => ['nullable', 'string', 'max:25'],
            'date_of_birth'      => ['nullable', 'date_format:d/m/Y'],
            'gender'             => ['nullable', 'in:Male,Female,Other'],
            'address'            => ['nullable', 'string'],
            'department'         => ['nullable', 'string', 'max:255'],
            'course'             => ['nullable', 'string', 'max:255'],
            'year_semester'      => ['nullable', 'string', 'max:50'],
            'membership_status' => ['required', Rule::in(['Active', 'Inactive', 'Suspended'])],
            'total_books_issued' => ['nullable', 'integer', 'min:0'],
            'max_book_limit'     => ['nullable', 'integer', 'min:0'],
            'fine_amount'        => ['nullable', 'numeric', 'min:0'],
            'photo'              => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:1024'],
            'blacklist_status'   => ['nullable', 'boolean'],
            'enrollment_date'    => ['nullable', 'date_format:d/m/Y'],
            'last_login'         => ['nullable', 'date'],
            'remark'             => ['nullable', 'string'],
            'compressed_photo'   => ['nullable', 'string', 'regex:/^data:image\/(jpeg|jpg|png);base64,/'],
        ];

        // First run base validation to normalize data
        $validated = $request->validate(array_merge($rules, [
            'enrollment_no' => ['string', 'max:100'],
            'student_library_id'    => ['required', 'string', 'max:100'],
        ]));

        // Normalize "N/A" values for special logic
        $validated['enrollment_no'] = trim($validated['enrollment_no']);
        $validated['student_library_id'] = trim($validated['student_library_id']);

        if (strcasecmp($validated['enrollment_no'], 'N/A') === 0) {
            $validated['enrollment_no'] = 'N/A';
        } else {
            $exists = \App\Models\Student::where('enrollment_no', $validated['enrollment_no'])
                ->when($id, fn($q) => $q->where('id', '!=', $id))
                ->exists();

            if ($exists) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'enrollment_no' => 'Entered Duplicate Enrollment Number.',
                ]);
            }
        }

        if (strcasecmp($validated['student_library_id'], 'N/A') === 0) {
            $validated['student_library_id'] = 'N/A';
        } else {
            $exists = \App\Models\Student::where('student_library_id', $validated['student_library_id'])
                ->when($id, fn($q) => $q->where('id', '!=', $id))
                ->exists();

            if ($exists) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'student_library_id' => 'Entered Duplicate Library ID.',
                ]);
            }
        }

        return $validated;
    }


    /**
     * Convert date fields from d/m/Y (user input) to Y-m-d (DB format).
     * Expects $data array with date strings.
     */
    private function convertDatesForStorage(array $data): array
    {
        if (!empty($data['registration_date'])) {
            $data['registration_date'] = Carbon::createFromFormat('d/m/Y', $data['registration_date'])->format('Y-m-d');
        }
        if (!empty($data['date_of_birth'])) {
            $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');
        }

        return $data;
    }

    /**
     * Store uploaded image file after resizing and compression.
     */
    private function storeImage(Request $request, string $field): ?string
    {
        if (!$request->hasFile($field)) {
            return null;
        }

        $image = $request->file($field);
        $extension = strtolower($image->getClientOriginalExtension());

        // Supported types only
        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return null;
        }

        // Load original image using GD
        switch ($extension) {
            case 'png':
                $src = imagecreatefrompng($image->getRealPath());
                break;
            case 'jpg':
            case 'jpeg':
                $src = imagecreatefromjpeg($image->getRealPath());
                break;
            default:
                return null;
        }

        $originalWidth = imagesx($src);
        $originalHeight = imagesy($src);

        $newWidth = 800;
        $newHeight = intval($originalHeight * ($newWidth / $originalWidth));

        // Prevent upscaling
        if ($originalWidth <= 800) {
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;
        }

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $src, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        $filename = 'students/' . uniqid('photo_', true) . '.jpg';
        $tempPath = storage_path('app/temp_' . uniqid() . '.jpg');

        // Save resized image to temp file at 75% quality
        imagejpeg($resized, $tempPath, 75);

        // Move to public disk
        Storage::disk('public')->put($filename, file_get_contents($tempPath));

        // Clean up
        unlink($tempPath);
        imagedestroy($src);
        imagedestroy($resized);

        return $filename;
    }
    public function searchByLibraryId($libraryId)
    {
        $student = Student::where('student_library_id', $libraryId)->first();

        if (!$student) {
            return response('<div class="alert alert-warning">Student not found.</div>', 404);
        }

        return view('backend.students._modal_show', compact('student'));
    }



    public function checkDuplicate(Request $request)
    {
        $enrollmentNo = $request->input('enrollment_no');
        $libraryId = $request->input('student_library_id');
        $studentId = $request->input('id'); // Optional, for edit mode

        $duplicateEnrollment = Student::where('enrollment_no', $enrollmentNo)
            ->when($studentId, fn($q) => $q->where('id', '!=', $studentId))
            ->exists();

        $duplicateLibrary = Student::where('student_library_id', $libraryId)
            ->when($studentId, fn($q) => $q->where('id', '!=', $studentId))
            ->exists();

        return response()->json([
            'enrollment_duplicate' => $duplicateEnrollment,
            'library_duplicate' => $duplicateLibrary,
        ]);
    }



    protected function storeBase64Image($base64String)
    {
        try {
            $image = Image::make($base64String)->encode('jpg', 80);
            $filename = 'students/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $image);
            return $filename;
        } catch (\Exception $e) {
            Log::error('Image compression error: ' . $e->getMessage());
            return null;
        }
    }

    public function modalPreview($student_library_id)
{
    $student = \App\Models\Student::where('student_library_id', $student_library_id)->first();

    if (!$student) {
        return response('Student not found', 404);
    }

    return view('backend.students._modal_show', compact('student'));
}

}
