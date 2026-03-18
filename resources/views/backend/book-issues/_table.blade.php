<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Student</th>
            <th>Book</th>
            <th>Issued At</th>
            <th>Due Date</th>
            <th>Returned At</th>
            {{-- <th>Status</th> --}}
            <th>Issued By</th>
            <th>Count</th>
            <th>Book Status</th>
            <th>Condition</th>
            <th>Remark</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($bookIssues as $issue)
            <tr>
                <td>{{ $loop->iteration }}</td>

                {{-- Student info --}}
                <td>
                    {{ $issue->student->student_library_id }}<br>
                    <small class="text-muted">{{ $issue->student->first_name }} {{ $issue->student->last_name }}</small>
                </td>

                {{-- Book ID --}}
                <td>{{ $issue->book_id }}</td>

                {{-- Issued --}}
                <td>{{ $issue->issued_at?->format('d/m/Y h:i A') ?? '-' }}</td>

                {{-- Due --}}
                <td>{{ $issue->due_date?->format('d/m/Y') ?? '-' }}</td>

                {{-- Returned --}}
                <td>
                    @if ($issue->returned_at)
                        {{ $issue->returned_at->format('d/m/Y h:i A') }}
                    @else
                        <span class="text-muted">Pending</span>
                    @endif
                </td>

                {{-- Status --}}
                {{-- <td>
                    @if ($issue->returned_at)
                        <span class="badge bg-success">Returned</span>
                    @elseif ($issue->is_overdue)
                        <span class="badge bg-danger">Overdue</span>
                    @else
                        <span class="badge bg-warning text-dark">Issued</span>
                    @endif
                </td> --}}

                {{-- Issued by --}}
                <td>{{ $issue->issuer->name ?? 'N/A' }}</td>

                {{-- Total Book Count at Issue --}}
                <td>{{ $issue->total_issued_book_count }}</td>

                {{-- Book Status at Issue --}}
                <td><span class="badge bg-warning text-dark">{{ ucfirst($issue->book_status) ?? '-' }}</span></td>
                <td>
                    @php
                        $condition = $issue->book_condition;
                        $badgeClass = match ($condition) {
                            'New' => 'success',
                            'Good' => 'primary',
                            'Fair' => 'warning',
                            'Damaged' => 'danger',
                            default => 'secondary',
                        };
                    @endphp

                    <span class="badge bg-{{ $badgeClass }}">
                        {{ $condition ?? 'N/A' }}
                    </span>
                </td>

                {{-- Remark --}}
                <td>{{ $issue->remark ?? '-' }}</td>

                {{-- Actions --}}
                <td>
                    <a href="{{ route('backend.book-issues.edit', $issue) }}" class="btn btn-sm btn-primary mb-1">✏️
                        Edit</a>
                    <form action="{{ route('backend.book-issues.destroy', $issue) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure to delete this record?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">🗑️ Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="text-center text-muted">No issued books found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
