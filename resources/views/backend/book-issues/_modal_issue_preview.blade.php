<div class="row g-3">
    <div class="col-md-6">
        <label><strong>📘 Issued To:</strong></label>
        <p>{{ $issue->student->full_name ?? 'N/A' }} ({{ $issue->student->student_library_id }})</p>
    </div>
    <div class="col-md-6">
        <label><strong>📅 Due Date:</strong></label>
        <p>{{ $issue->due_date?->format('d/m/Y') ?? 'N/A' }}</p>
    </div>
    <div class="col-md-6">
        <label><strong>📖 Book Title:</strong></label>
        <p>{{ $issue->book->title ?? 'N/A' }}</p>
    </div>
    <div class="col-md-6">
        <label><strong>Status:</strong></label>
        <span class="badge bg-warning text-dark">{{ ucfirst($issue->status) }}</span>
    </div>
</div>
