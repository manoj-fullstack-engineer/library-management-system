@php
    $fullName = collect([
        $bookIssue->student->first_name,
        $bookIssue->student->middle_name,
        $bookIssue->student->last_name,
    ])->filter()->implode(' ');
@endphp

<strong>👤 Issued To:</strong> {{ $fullName }} ({{ $bookIssue->student_library_id }})

<div class="p-2">
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <strong>📚 Book ID:</strong> {{ $bookIssue->book->id }}<br>
            <strong>Title:</strong> {{ $bookIssue->book->title ?? '-' }}
        </li>
        <li class="list-group-item">
            <strong>👤 Issued To:</strong> {{ $fullName  ?? 'N/A' }} ({{ $bookIssue->student_library_id }})
        </li>
        <li class="list-group-item">
            <strong>📅 Issued On:</strong> {{ $bookIssue->issued_at->format('d M Y, h:i A') }}
        </li>
        <li class="list-group-item">
            <strong>📅 Due Date:</strong> {{ \Carbon\Carbon::parse($bookIssue->due_date)->format('d M Y') }}
        </li>
        @if ($bookIssue->remark)
        <li class="list-group-item">
            <strong>📝 Remark:</strong> {{ $bookIssue->remark }}
        </li>
        @endif
    </ul>
</div>
