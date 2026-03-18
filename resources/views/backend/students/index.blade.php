@extends('layouts.admin')

@section('title', 'Students Management')

@section('content')
    <div class="container-fluid">
        <div class="card shadow rounded">
            <div class="card-header bg-light border-bottom">
                <div class="row align-items-center justify-content-between g-2">
                    <div class="col-md-auto">
                        <h5 class="mb-0">📚 Students List</h5>
                    </div>
                    <div class="col text-end">
                        <div class="btn-group flex-wrap gap-1">
                            <a href="{{ route('backend.students.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Add Student
                            </a>
                            <a href="{{ route('backend.students.excel', request()->only('search', 'from', 'to')) }}"
                                class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-excel"></i> Excel
                            </a>
                            <a href="{{ route('backend.students.pdf', request()->only('search', 'from', 'to')) }}"
                                class="btn btn-danger btn-sm" target="_blank">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </a>
                            <a href="{{ route('backend.students.print', request()->only('search', 'from', 'to')) }}"
                                class="btn btn-info btn-sm" target="_blank">
                                <i class="bi bi-printer"></i> Print
                            </a>
                            <button id="bulk-delete-btn" class="btn btn-outline-danger btn-sm" disabled>
                                <i class="bi bi-trash"></i> Delete Selected
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('backend.students.index') }}" method="GET" class="row g-2 mb-4">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="🔍 Search students..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="from" class="form-control" value="{{ request('from') }}"
                            placeholder="From">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="to" class="form-control" value="{{ request('to') }}"
                            placeholder="To">
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('backend.students.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    </div>
                </form>

                <form id="bulk-delete-form" action="{{ route('backend.students.bulkDelete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ids[]" id="bulk-delete-ids">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col"><input type="checkbox" id="select-all"></th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Lib ID</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Black List</th>
                                    <th scope="col">Enrl No</th>
                                    <th scope="col">Enrl Date (dd/mm/yyyy)</th>

                                    <th scope="col" class="text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        {{-- 1. Checkbox --}}
                                        <td>
                                            <input type="checkbox" name="ids[]" value="{{ $student->id }}"
                                                class="select-row">
                                        </td>

                                        {{-- 2. ID --}}
                                        <td>{{ $student->id }}</td>

                                        {{-- 3. Library ID --}}
                                        <td>{{ $student->student_library_id }}</td>

                                        {{-- 4. Photo --}}
                                        <td>
                                            @php
                                                // use Illuminate\Support\Facades\Storage;

                                                $photoPath =
                                                    $student->photo && Storage::disk('public')->exists($student->photo)
                                                        ? Storage::url($student->photo)
                                                        : asset('storage/images/default-user.png');
                                            @endphp

                                            <img src="{{ $photoPath }}" alt="Photo" width="40" height="40"
                                                class="rounded-circle object-fit-cover border" />
                                        </td>


                                        {{-- 5. Full Name --}}
                                        <td>{{ $student->first_name }} {{ $student->middle_name }}
                                            {{ $student->last_name }}</td>

                                        {{-- 6. Course --}}
                                        <td>{{ $student->course }}</td>

                                        {{-- 7. Semester --}}
                                        <td>{{ $student->year_semester }}</td>

                                        {{-- 8. Status --}}
                                        <td>
                                            @switch($student->membership_status)
                                                @case('Active')
                                                    <span class="badge bg-success-subtle text-success">Active</span>
                                                @break

                                                @case('Inactive')
                                                    <span class="badge bg-warning-subtle text-warning">Inactive</span>
                                                @break

                                                @case('Suspended')
                                                    <span class="badge bg-danger-subtle text-danger">Suspended</span>
                                                @break

                                                @default
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary">{{ ucfirst($student->status) }}</span>
                                            @endswitch
                                        </td>

                                        {{-- 9. Black List --}}
                                        <td>
                                            @if ($student->blacklist_status)
                                                <span class="badge bg-danger text-white">Yes</span>
                                            @else
                                                <span class="badge bg-success text-white">No</span>
                                            @endif
                                        </td>

                                        {{-- 10. Enrollment No --}}
                                        <td>{{ $student->enrollment_no }}</td>
                                        <td>
                                            {{ $student->enrollment_date ? \Carbon\Carbon::parse($student->enrollment_date)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        {{-- 11. Actions --}}
                                        <td class="text-nowrap">
                                            <a href="{{ route('backend.students.show', $student) }}"
                                                class="btn btn-sm btn-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('backend.students.edit', $student) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('backend.students.destroy', $student) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this student?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center text-muted">No students found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </form>

                    <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 gap-2">
                        {{-- Per Page Selector --}}
                        <form method="GET" class="d-flex align-items-center gap-2">
                            {{-- Preserve existing filters --}}
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="from" value="{{ request('from') }}">
                            <input type="hidden" name="to" value="{{ request('to') }}">

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

                        {{-- Pagination --}}
                        @if ($students instanceof \Illuminate\Pagination\LengthAwarePaginator && request('per_page') !== 'all')
                            <div class="ms-auto">
                                {{ $students->links() }}
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
                const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
                const bulkDeleteForm = document.getElementById('bulk-delete-form');
                const bulkDeleteIds = document.getElementById('bulk-delete-ids');

                function updateBulkDeleteButton() {
                    const selected = [...checkboxes].filter(chk => chk.checked).map(chk => chk.value);
                    bulkDeleteBtn.disabled = selected.length === 0;
                    bulkDeleteIds.value = selected.join(',');
                }

                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(chk => chk.checked = selectAll.checked);
                    updateBulkDeleteButton();
                });

                checkboxes.forEach(chk => chk.addEventListener('change', updateBulkDeleteButton));

                bulkDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Delete selected students?')) {
                        bulkDeleteForm.submit();
                    }
                });
            });
        </script>
    @endpush
