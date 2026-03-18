@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">🔄 Return a Book</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('backend.book-returns.store') }}" method="POST" class="row g-4">
        @csrf

        {{-- Student ID --}}
        <div class="col-md-6">
            <label for="student_library_id" class="form-label fw-semibold">🎓 Student ID</label>
            <input type="text" name="student_library_id" id="student_library_id" value="{{ old('student_library_id') }}"
                class="form-control" required placeholder="L101">
        </div>

        {{-- Book ID --}}
        <div class="col-md-6">
            <label for="book_id" class="form-label fw-semibold">📘 Book ID</label>
            <input type="number" name="book_id" id="book_id" value="{{ old('book_id') }}"
                class="form-control" required placeholder="Enter Book ID">
        </div>

        {{-- Return Date --}}
        <div class="col-md-6">
            <label for="return_date" class="form-label fw-semibold">📅 Return Date</label>
            <input type="datetime-local" name="return_date" id="return_date"
                value="{{ old('return_date', now()->format('Y-m-d\TH:i')) }}"
                class="form-control" required>
        </div>

        {{-- Book Condition --}}
        <div class="col-md-6">
            <label for="book_condition" class="form-label fw-semibold">📦 Book Condition</label>
            <select name="book_condition" id="book_condition" class="form-select" required>
                <option value="">-- Select Condition --</option>
                <option value="Good" {{ old('book_condition') == 'Good' ? 'selected' : '' }}>Good</option>
                <option value="Damaged" {{ old('book_condition') == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                <option value="Lost" {{ old('book_condition') == 'Lost' ? 'selected' : '' }}>Lost</option>
            </select>
        </div>

        {{-- Fine Amount --}}
        <div class="col-md-6">
            <label for="fine_amount" class="form-label fw-semibold">💰 Fine (₹)</label>
            <input type="number" step="0.01" name="fine_amount" id="fine_amount"
                value="{{ old('fine_amount') }}" class="form-control" placeholder="Optional">
        </div>

        {{-- Remark --}}
        <div class="col-md-12">
            <label for="return_remark" class="form-label fw-semibold">📝 Remark</label>
            <textarea name="return_remark" id="return_remark" rows="3" class="form-control" placeholder="Return note...">{{ old('return_remark') }}</textarea>
        </div>

        {{-- Submit --}}
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-success">💾 Submit Return</button>
            <a href="{{ route('backend.book-returns.index') }}" class="btn btn-secondary">⏪ Back to Logs</a>
        </div>
    </form>
</div>
@endsection
<script>
document.getElementById('book_id_return').addEventListener('change', function () {
    const bookId = this.value;
    if (!bookId || isNaN(bookId)) return;

    fetch(`/backend/book-issue-returns/fetch-issue-info/${bookId}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            const d = res.data;
            document.getElementById('student_library_id').value = d.student_library_id;
            document.getElementById('fine_amount').value = d.auto_fine || 0;
            document.getElementById('return_date').value = new Date().toISOString().slice(0, 16);

            Swal.fire({
                icon: d.is_overdue ? 'warning' : 'info',
                title: d.is_overdue ? `⚠️ Overdue by ${d.days_late} day(s)` : 'Book Issued',
                html: `
                    <b>Student:</b> ${d.student_name}<br>
                    <b>Issued At:</b> ${d.issued_at}<br>
                    <b>Due Date:</b> ${d.due_date || 'N/A'}<br>
                    <b>Auto Fine:</b> ₹${d.auto_fine}
                `
            });
        } else {
            Swal.fire('Not Found', res.message, 'warning');
        }
    })
    .catch(() => {
        Swal.fire('Error', 'Failed to fetch book issue details.', 'error');
    });
});
</script>
