@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">📘 Return Book</h3>
        <a href="{{ route('backend.book-returns.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm">
            <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('backend.book-returns.store') }}" method="POST" class="card border-0 shadow-sm">
        @csrf
        <div class="card-body">
            <div class="row g-4">
                {{-- Book ID --}}
                <div class="col-md-6">
                    <label for="book_id_input" class="form-label">Book ID <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="book_id" id="book_id_input" class="form-control" required placeholder="Enter Book ID">
                        <button type="button" class="btn btn-primary" onclick="fetchBookDetails()">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>

                {{-- Book Info --}}
                <div class="col-md-6">
                    <label class="form-label">Book Title</label>
                    <input type="text" id="book_title" class="form-control" readonly placeholder="Auto-filled">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Book Status</label>
                    <input type="text" id="book_status" class="form-control" readonly placeholder="Auto-filled">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Issued By</label>
                    <input type="text" id="issued_by" class="form-control" readonly placeholder="Auto-filled">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Student Library ID</label>
                    <input type="text" id="student_library_id" name="student_library_id" class="form-control" readonly>
                </div>

                {{-- Dates --}}
                <div class="col-md-4">
                    <label class="form-label">Issue Date</label>
                    <input type="text" id="issue_date_display" class="form-control" readonly>
                    <input type="hidden" name="issue_date" id="issue_date">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Due Date</label>
                    <input type="text" id="due_date_display" class="form-control" readonly>
                    <input type="hidden" name="due_date" id="due_date_hidden">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Student Name</label>
                    <input type="text" id="student_name" class="form-control" readonly placeholder="Auto-filled">
                </div>

                {{-- Return Details --}}
                <div class="col-md-4">
                    <label for="return_date" class="form-label">Return Date <span class="text-danger">*</span></label>
                    <input type="date" name="return_date" id="return_date" class="form-control"
                           value="{{ date('Y-m-d') }}" required onkeydown="return false;" onchange="calculateFine()">
                </div>

                <div class="col-md-4">
                    <label for="condition_on_return" class="form-label">Condition on Return</label>
                    <select name="condition_on_return" id="condition_on_return" class="form-select">
                        <option value="">-- Select --</option>
                        <option value="Good">Good</option>
                        <option value="Damaged">Damaged</option>
                        <option value="Lost">Lost</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="fine_amount" class="form-label">Fine (₹)</label>
                    <input type="number" name="fine_amount" id="fine_amount" class="form-control" step="0.01" placeholder="0.00">
                    <div class="form-text text-muted">Auto-calculated (₹5/day after due), but editable</div>
                </div>

                <div class="col-md-12">
                    <label for="remark" class="form-label">Remarks</label>
                    <textarea name="remark" id="remark" rows="2" class="form-control" placeholder="Optional remarks"></textarea>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-check-circle me-1"></i> Submit Return
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function formatDate(dateStr) {
            if (!dateStr) return '';
            const [y, m, d] = dateStr.split("-");
            return `${d}/${m}/${y}`;
        }

        function fetchBookDetails() {
            const bookId = document.getElementById('book_id_input').value.trim();
            if (!bookId) return alert("Please enter Book ID");

            fetch(`/backend/book-returns/fetch-issue-info/${bookId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        clearBookFields();
                        return;
                    }

                    document.getElementById('book_title').value = data.book?.title ?? '';
                    document.getElementById('book_status').value = data.book?.status ?? '';
                    document.getElementById('issued_by').value = data.issued_by ?? '';
                    document.getElementById('student_library_id').value = data.student?.student_library_id ?? '';
                    document.getElementById('student_name').value = data.student?.full_name ?? '';

                    document.getElementById('issue_date').value = data.issue_date ?? '';
                    document.getElementById('issue_date_display').value = formatDate(data.issue_date);
                    document.getElementById('due_date_hidden').value = data.due_date ?? '';
                    document.getElementById('due_date_display').value = formatDate(data.due_date);

                    setReturnDateLimits(data.issue_date);
                    calculateFine();
                })
                .catch(err => {
                    alert("Something went wrong while fetching book info.");
                    console.error(err);
                });
        }

        function clearBookFields() {
            const ids = ['book_title', 'book_status', 'issued_by', 'student_library_id', 'student_name', 'issue_date', 'issue_date_display', 'due_date_hidden', 'due_date_display'];
            ids.forEach(id => document.getElementById(id).value = '');
        }

        function setReturnDateLimits(issueDate) {
            const returnInput = document.getElementById('return_date');
            const today = new Date().toISOString().split('T')[0];
            returnInput.min = issueDate;
            returnInput.max = today;
        }

        function calculateFine() {
            const dueDateStr = document.getElementById('due_date_hidden').value;
            const returnDateStr = document.getElementById('return_date').value;

            if (!dueDateStr || !returnDateStr) return;

            const due = new Date(dueDateStr);
            const ret = new Date(returnDateStr);

            if (ret > due) {
                const diffTime = Math.abs(ret - due);
                const lateDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const fine = lateDays * 5;
                document.getElementById('fine_amount').value = fine.toFixed(2);
            } else {
                document.getElementById('fine_amount').value = '0.00';
            }
        }
    </script>
@endpush
