<h2>📘 Book Returned Summary</h2>
<p><strong>Student:</strong> {{ $bookIssue->student->full_name }} ({{ $bookIssue->student->student_library_id }})</p>
<p><strong>Book:</strong> {{ $bookIssue->book->title }}</p>
<p><strong>Issued On:</strong> {{ $bookIssue->issued_at->format('d M Y') }}</p>
<p><strong>Returned On:</strong> {{ $bookIssue->returned_at->format('d M Y') }}</p>
<p><strong>Book Condition:</strong> {{ $bookIssue->book_condition ?? 'N/A' }}</p>
<p><strong>Remark:</strong> {{ $bookIssue->return_remark ?? 'None' }}</p>
@if($bookIssue->fine_amount > 0)
    <p><strong>⚠ Fine Amount:</strong> ₹{{ number_format($bookIssue->fine_amount, 2) }}</p>
@endif
