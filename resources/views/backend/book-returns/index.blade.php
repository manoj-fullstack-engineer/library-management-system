@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">📚 Returned Books</h3>
        <a href="{{ route('backend.book-returns.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Return Book
        </a>
    </div>

    {{-- 🔍 Filters --}}
    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Student ID</label>
                    <input type="text" name="student_library_id" value="{{ request('student_library_id') }}" class="form-control" placeholder="Enter Library ID">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Book ID</label>
                    <input type="text" name="book_id" value="{{ request('book_id') }}" class="form-control" placeholder="Enter Book ID">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Condition</label>
                    <select name="condition" class="form-select">
                        <option value="">-- Any --</option>
                        <option value="Good" {{ request('condition') == 'Good' ? 'selected' : '' }}>Good</option>
                        <option value="Damaged" {{ request('condition') == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                        <option value="Lost" {{ request('condition') == 'Lost' ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date Range</label>
                    <div class="input-group">
                        <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                        <span class="input-group-text">to</span>
                        <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                    </div>
                </div>

                <div class="col-md-12 mt-3 text-center">
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('backend.book-returns.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                        <a href="{{ route('backend.book-returns.excel', request()->all()) }}" class="btn btn-outline-success">
                            <i class="fas fa-file-excel me-1"></i> Excel
                        </a>
                        <a href="{{ route('backend.book-returns.pdf', request()->all()) }}" class="btn btn-outline-danger">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </a>
                        <a href="{{ route('backend.book-returns.print', request()->all()) }}" class="btn btn-outline-dark" target="_blank">
                            <i class="fas fa-print me-1"></i> Print
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- 📊 Table --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Student ID</th>
                        <th>Book ID</th>
                        <th>Returned On</th>
                        <th>Condition</th>
                        <th>Fine (₹)</th>
                        <th>Processed By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returns as $return)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $return->student_library_id }}</td>
                            <td>{{ $return->book_id }}</td>
                            <td>{{ \Carbon\Carbon::parse($return->return_date)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $return->condition_on_return === 'Damaged' ? 'danger' : ($return->condition_on_return === 'Good' ? 'success' : 'warning') }}">
                                    {{ $return->condition_on_return ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ number_format($return->fine_amount, 2) }}</td>
                            <td>{{ $return->processedBy->name ?? '-' }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-info" onclick="previewReturn({{ $return->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('backend.book-returns.edit', $return->id) }}" class="dropdown-item">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('backend.book-returns.destroy', $return->id) }}" method="POST" onsubmit="return confirm('Delete this return?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No return records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $returns->withQueryString()->links() }}
        </div>
    </div>

    {{-- 🔍 Modal Preview --}}
    <div class="modal fade" id="returnPreviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content" id="return-preview-body">
                {{-- AJAX content will be injected here --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewReturn(id) {
            const url = `/backend/book-returns/${id}/preview`;
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('return-preview-body').innerHTML = html;
                    const modal = new bootstrap.Modal(document.getElementById('returnPreviewModal'));
                    modal.show();
                });
        }
    </script>
@endpush
