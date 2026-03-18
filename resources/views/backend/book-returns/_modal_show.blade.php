<div class="modal-header">
    <h5 class="modal-title">Return Log Preview</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <div class="row mb-3">
        <div class="col-md-6">
            <h6 class="text-muted">📚 Book Info</h6>
            <p><strong>Book ID:</strong> {{ $return->book->id }}</p>
            <p><strong>Title:</strong> {{ $return->book->title ?? 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <h6 class="text-muted">👤 Student Info</h6>
            <p><strong>Library ID:</strong> {{ $return->student_library_id }}</p>
            <p><strong>Name:</strong> {{ $return->student->name ?? 'Unknown' }}</p>
            <p><strong>Class:</strong> {{ $return->student->class ?? '-' }}</p>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <h6 class="text-muted">📅 Dates</h6>
            <p><strong>Issue Date:</strong> {{ \Carbon\Carbon::parse($return->issue_date)->format('d M Y') }}</p>
            <p><strong>Return Date:</strong> {{ \Carbon\Carbon::parse($return->return_date)->format('d M Y') }}</p>
        </div>
        <div class="col-md-6">
            <h6 class="text-muted">📝 Return Status</h6>
            <p><strong>Condition:</strong>
                <span class="badge bg-{{ $return->condition_on_return == 'Damaged' ? 'danger' : ($return->condition_on_return == 'Good' ? 'success' : 'warning') }}">
                    {{ $return->condition_on_return ?? 'N/A' }}
                </span>
            </p>
            <p><strong>Fine:</strong> ₹{{ number_format($return->fine_amount, 2) }}</p>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
