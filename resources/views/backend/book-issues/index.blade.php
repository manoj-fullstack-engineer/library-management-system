@extends('layouts.admin')

@section('title', 'Book Issues')

@section('content')
    <div class="container-fluid">
        <div class="card shadow rounded">
            <div class="card-header bg-light border-bottom">
                <div class="row align-items-center justify-content-between g-2">
                    <div class="col-md-auto">
                        <h5 class="mb-0">📚 Issued Books</h5>
                    </div>
                    <div class="col text-end">
                        <div class="btn-group flex-wrap gap-1">
                            <a href="{{ route('backend.book-issues.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Issue Book
                            </a>
                            <a href="{{ route('backend.book-issues.excel', request()->only('search', 'from', 'to', 'status')) }}"
                                class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-excel"></i> Excel
                            </a>
                            <a href="{{ route('backend.book-issues.pdf', request()->only('search', 'from', 'to', 'status')) }}"
                                class="btn btn-danger btn-sm" target="_blank">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </a>
                            <a href="{{ route('backend.book-issues.print', request()->only('search', 'from', 'to', 'status')) }}"
                                class="btn btn-info btn-sm" target="_blank">
                                <i class="bi bi-printer"></i> Print
                            </a>
                            <form method="POST" action="{{ route('backend.book-issues.bulkReturn') }}">
                                @csrf
                                {{-- checkboxes with issue_ids[] --}}
                                <button type="submit" class="btn btn-warning">Return Selected</button>
                            </form>

                            <form method="POST" action="{{ route('backend.book-issues.bulkDelete') }}">
                                @csrf
                                @method('DELETE')
                                {{-- checkboxes for issue_ids[] --}}
                                <button type="submit" class="btn btn-danger">🗑️ Delete Selected</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{-- Filters --}}
                <form action="{{ route('backend.book-issues.index') }}" method="GET" class="row g-2 mb-4">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control"
                            placeholder="🔍 Search books or students..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="from" class="form-control" value="{{ request('from') }}"
                            placeholder="From Date">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="to" class="form-control" value="{{ request('to') }}"
                            placeholder="To Date">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="Issued" {{ request('status') == 'Issued' ? 'selected' : '' }}>Issued</option>
                            <option value="Returned" {{ request('status') == 'Returned' ? 'selected' : '' }}>Returned
                            </option>
                            <option value="Overdue" {{ request('status') == 'Overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('backend.book-issues.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    </div>
                </form>

                {{-- Table & Bulk Form --}}
                <form id="bulk-actions-form" method="POST">
                    @csrf
                    <input type="hidden" name="ids" id="bulk-ids">
                    <div class="table-responsive">
                        @include('backend.book-issues._table', ['bookIssues' => $bookIssues])
                    </div>
                </form>

                {{-- Pagination & Per Page --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 gap-2">
                    <form method="GET" class="d-flex align-items-center gap-2">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="from" value="{{ request('from') }}">
                        <input type="hidden" name="to" value="{{ request('to') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}">

                        <label for="per_page" class="mb-0 small text-muted">Show</label>
                        <select name="per_page" id="per_page" class="form-select form-select-sm w-auto"
                            onchange="this.form.submit()">
                            @foreach ([10, 20, 50, 100, 'all'] as $option)
                                <option value="{{ $option }}"
                                    {{ request('per_page', 10) == $option ? 'selected' : '' }}>
                                    {{ is_numeric($option) ? $option : 'All' }}
                                </option>
                            @endforeach
                        </select>
                        <label class="mb-0 small text-muted">records</label>
                    </form>

                    @if ($bookIssues instanceof \Illuminate\Pagination\LengthAwarePaginator && request('per_page') !== 'all')
                        <div class="ms-auto">
                            {{ $bookIssues->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.select-row');
            const bulkReturnBtn = document.getElementById('bulk-return-btn');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const bulkForm = document.getElementById('bulk-actions-form');
            const bulkIds = document.getElementById('bulk-ids');

            function updateBulkButtons() {
                const selected = [...checkboxes].filter(chk => chk.checked).map(chk => chk.value);
                bulkIds.value = selected.join(',');
                bulkReturnBtn.disabled = selected.length === 0;
                bulkDeleteBtn.disabled = selected.length === 0;
            }

            selectAll?.addEventListener('change', function() {
                checkboxes.forEach(chk => chk.checked = selectAll.checked);
                updateBulkButtons();
            });

            checkboxes.forEach(chk => chk.addEventListener('change', updateBulkButtons));

            bulkReturnBtn?.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Mark selected books as returned?')) {
                    bulkForm.action = "{{ route('backend.book-issues.bulkReturn') }}";
                    bulkForm.submit();
                }
            });

            bulkDeleteBtn?.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Delete selected book issues?')) {
                    bulkForm.action = "{{ route('backend.book-issues.bulkDelete') }}";
                    bulkForm.submit();
                }
            });
        });
    </script>
@endpush
