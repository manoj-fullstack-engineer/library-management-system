<div class="tab-pane fade" id="academic-info" role="tabpanel">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="enrollment_no" class="form-label">Enrollment No </label>
            <input type="text" name="enrollment_no" id="enrollment_no" class="form-control"
                   value="{{ old('enrollment_no', $student->enrollment_no ?? 'N/A') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="student_library_id" class="form-label">Library ID <span class="text-danger">*</span></label>
            <input type="text" name="student_library_id" id="student_library_id" class="form-control"
                   value="{{ old('student_library_id', $student->student_library_id ?? '') }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" name="department" id="department" class="form-control"
                   value="{{ old('department', $student->department ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="course" class="form-label">Course</label>
            <input type="text" name="course" id="course" class="form-control"
                   value="{{ old('course', $student->course ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="year_semester" class="form-label">Year/Semester</label>
            <input type="text" name="year_semester" id="year_semester" class="form-control"
                   value="{{ old('year_semester', $student->year_semester ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="membership_status" class="form-label">Membership Status</label>
            <select name="membership_status" id="membership_status" class="form-select">
                <option value="Active" {{ old('membership_status', $student->membership_status ?? '') === 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('membership_status', $student->membership_status ?? '') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="Suspended" {{ old('membership_status', $student->membership_status ?? '') === 'Suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="blacklist_status" class="form-label">Blacklist Status</label>
            <select name="blacklist_status" id="blacklist_status" class="form-select">
                <option value="0" {{ old('blacklist_status', $student->blacklist_status ?? '') == '0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('blacklist_status', $student->blacklist_status ?? '') == '1' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="enrollment_date" class="form-label">Enrollment Date</label>
            <input type="date" name="enrollment_date" id="enrollment_date" class="form-control"
                   value="{{ old('enrollment_date', $student->enrollment_date ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="total_books_issued" class="form-label">Total Books Issued</label>
            <input type="number" name="total_books_issued" id="total_books_issued" class="form-control"
                   value="{{ old('total_books_issued', $student->total_books_issued ?? 0) }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="max_book_limit" class="form-label">Max Book Limit</label>
            <input type="number" name="max_book_limit" id="max_book_limit" class="form-control"
                   value="{{ old('max_book_limit', $student->max_book_limit ?? 3) }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="fine_amount" class="form-label">Fine Amount</label>
            <input type="number" name="fine_amount" id="fine_amount" step="0.01" class="form-control"
                   value="{{ old('fine_amount', $student->fine_amount ?? 0) }}">
        </div>
    </div>
</div>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: '{{ session('error') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
    });
</script>
@endif
