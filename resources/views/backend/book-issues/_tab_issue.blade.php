<div class="tab-pane fade show active" id="tab-issue" role="tabpanel">
    <div class="row g-4">
        {{-- Student Library ID --}}
        <div class="col-md-6">
            <label for="student_library_id" class="form-label fw-semibold">📘 Student Library ID</label>
            <div class="input-group shadow-sm">
                <input type="text" id="student_library_id" name="student_library_id" class="form-control"
                    value="{{ old('student_library_id', $bookIssue->student_library_id ?? '') }}"
                    placeholder="Enter Library ID">
                <button type="button" class="btn btn-outline-primary" onclick="previewStudent()" title="Preview Student">
                    🔍
                </button>
            </div>
        </div>

        {{-- Book ID --}}
        <div class="col-md-6">
            <label for="book_id" class="form-label fw-semibold">📗 Book ID</label>
            <div class="input-group shadow-sm">
                <input type="text" id="book_id" name="book_id" class="form-control"
                    value="{{ old('book_id', $bookIssue->book_id ?? '') }}" placeholder="Enter Book ID">
                <button type="button" class="btn btn-outline-primary" onclick="previewBook()" title="Preview Book">
                    🔍
                </button>
            </div>
        </div>

        {{-- Book Condition --}}
        <div class="col-md-6">
            <label for="book_condition" class="form-label fw-semibold">📖 Book Condition</label>
            <select name="book_condition" id="book_condition" class="form-select shadow-sm">
                <option value="">-- Select Condition --</option>
                @foreach (['New', 'Good', 'Fair', 'Damaged'] as $condition)
                    <option value="{{ $condition }}"
                        {{ old('book_condition', $bookIssue->book_condition ?? '') === $condition ? 'selected' : '' }}>
                        {{ $condition }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Due Date --}}
        <div class="col-md-6">
            <label for="due_date" class="form-label fw-semibold">📅 Due Date <span class="text-danger">*</span></label>
            <input type="date" name="due_date" id="due_date" class="form-control shadow-sm"
                value="{{ old('due_date', isset($bookIssue) ? \Carbon\Carbon::parse($bookIssue->due_date)->format('Y-m-d') : '') }}"
                required>
        </div>

        {{-- Remark --}}
        <div class="col-md-12">
            <label for="remark" class="form-label fw-semibold">📝 Remark</label>
            <textarea name="remark" id="remark" class="form-control shadow-sm" rows="3"
                placeholder="Add any remarks...">{{ old('remark', $bookIssue->remark ?? '') }}</textarea>
        </div>

        {{-- Actions --}}
        <div class="col-12 text-center mt-4 mb-2">
            <button type="submit" class="btn btn-success">💾 Save</button>
            <a href="{{ route('backend.book-issues.index') }}" class="btn btn-secondary">✖ Exit</a>
        </div>
    </div>
</div>

{{-- Student Modal --}}
<div class="modal fade" id="studentPreviewModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="studentModalLabel">👤 Student Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="studentPreviewBody">
                <div class="text-center text-muted">Loading student details...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">✖ Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Book Modal --}}
<div class="modal fade" id="bookPreviewModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="bookModalLabel">📚 Book Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="bookPreviewBody">
                <div class="text-center text-muted">Loading book details...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">✖ Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    function previewStudent() {
        const studentId = document.getElementById('student_library_id').value.trim();
        if (!studentId) {
            return Swal.fire('Missing ID', 'Please enter a Student Library ID first.', 'warning');
        }

        fetch(`/backend/students/modal-preview/${studentId}`)
            .then(res => res.ok ? res.text() : Promise.reject())
            .then(html => {
                document.getElementById('studentPreviewBody').innerHTML = html;
                new bootstrap.Modal(document.getElementById('studentPreviewModal')).show();
            })
            .catch(() => {
                document.getElementById('studentPreviewBody').innerHTML = '<div class="text-danger">Student not found.</div>';
                new bootstrap.Modal(document.getElementById('studentPreviewModal')).show();
            });
    }

    function previewBook() {
        const bookId = document.getElementById('book_id').value.trim();
        if (!bookId) {
            return Swal.fire('Missing ID', 'Please enter a Book ID first.', 'warning');
        }

        fetch(`/backend/books/modal-preview/${bookId}`)
            .then(res => res.ok ? res.text() : Promise.reject())
            .then(html => {
                document.getElementById('bookPreviewBody').innerHTML = html;
                new bootstrap.Modal(document.getElementById('bookPreviewModal')).show();
            })
            .catch(() => {
                document.getElementById('bookPreviewBody').innerHTML = '<div class="text-danger">Book not found.</div>';
                new bootstrap.Modal(document.getElementById('bookPreviewModal')).show();
            });
    }
</script>
