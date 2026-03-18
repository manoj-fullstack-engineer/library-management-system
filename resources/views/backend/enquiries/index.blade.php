@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Enquiry Management</h4>
            <a href="{{ route('backend.enquiries.create') }}" class="btn btn-primary">Add New Enquiry</a>
        </div>

        {{-- Filter Section --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('backend.enquiries.index') }}" class="row g-3 align-items-end mb-3">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Global Search..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Filter by Name"
                            value="{{ request('name') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="created_from" class="form-control"
                            value="{{ request('created_from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="created_to" class="form-control" value="{{ request('created_to') }}">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 btn-sm">Search</button>
                        <a href="{{ route('backend.enquiries.index') }}" class="btn btn-secondary w-100 btn-sm">Reset</a>
                    </div>
                </form>

                <div class="row g-2">
                    <div class="col-md-2">
                        <form method="GET" action="{{ route('backend.enquiries.export.excel') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="name" value="{{ request('name') }}">
                            <input type="hidden" name="created_from" value="{{ request('created_from') }}">
                            <input type="hidden" name="created_to" value="{{ request('created_to') }}">
                            <button type="submit" class="btn btn-success w-100 btn-sm">Export Excel</button>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form method="GET" action="{{ route('backend.enquiries.export.pdf') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="name" value="{{ request('name') }}">
                            <input type="hidden" name="created_from" value="{{ request('created_from') }}">
                            <input type="hidden" name="created_to" value="{{ request('created_to') }}">
                            <button type="submit" class="btn btn-danger w-100 btn-sm">Export PDF</button>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form method="GET" action="{{ route('backend.enquiries.print') }}" target="_blank">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="name" value="{{ request('name') }}">
                            <input type="hidden" name="created_from" value="{{ request('created_from') }}">
                            <input type="hidden" name="created_to" value="{{ request('created_to') }}">
                            <button type="submit" class="btn btn-secondary btn-sm">Print</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>




        {{-- Export/Print & Bulk Delete --}}
        {{-- <div class="mb-3 d-flex justify-content-between">
            <div>
                <a href="#" id="exportExcelBtn" class="btn btn-success btn-sm">Export Excel</a>
                <a href="#" id="exportPdfBtn" class="btn btn-danger btn-sm">Export PDF</a>
                <a href="#" id="printBtn" class="btn btn-secondary btn-sm" target="_blank">Print</a>
            </div>
        </div> --}}


        <div class="mt-3">
            {{ $enquiries->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

        {{-- Enquiries Table --}}
        <div class="table-responsive">
            <table id="enquiriesTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enquiries as $enquiry)
                        <tr>
                            <td><input type="checkbox" class="selectRow" value="{{ $enquiry->id }}"></td>
                            <td>{{ $enquiry->created_at->format('d M Y') }}</td>
                            <td>{{ $enquiry->name }}</td>
                            <td>{{ $enquiry->email }}</td>
                            <td>{{ $enquiry->phone }}</td>
                            <td>{{ $enquiry->subject }}</td>
                            <td>{{ $enquiry->status }}</td>

                            <td>
                                <a href="{{ route('backend.enquiries.show', $enquiry->id) }}"
                                    class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('backend.enquiries.edit', $enquiry->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('backend.enquiries.destroy', $enquiry->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Del</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Bootstrap 5 Styled Pagination --}}
        <div class="mt-3">
            {{ $enquiries->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#enquiriesTable').DataTable({
                "paging": false, // disable DataTables paging to avoid conflict with Laravel pagination
                "info": false,
                "searching": false,
            });

            // Select all checkboxes
            $('#selectAll').on('click', function() {
                $('.selectRow').prop('checked', this.checked);
            });

            // Single delete confirmation
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Bulk delete confirmation
            $('#bulkDeleteForm').on('submit', function(e) {
                let ids = $('.selectRow:checked').map(function() {
                    return this.value;
                }).get().join(',');

                if (!ids) {
                    e.preventDefault();
                    Swal.fire('Please select at least one enquiry.', '', 'warning');
                    return false;
                }

                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete selected enquiries? This cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#bulk-delete-ids').val(ids);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
