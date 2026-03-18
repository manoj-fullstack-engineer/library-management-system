@extends('layouts.admin')

@section('content')
    <div class="container">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Users Management</h1>
            <a href="{{ route('backend.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add New User
            </a>
        </div>

        {{-- Filter Section --}}
        @include('backend.users.partials.filters')

        {{-- Action Buttons --}}
        <div class="mb-3">
            @include('backend.users.partials.action-buttons')
        </div>

        {{-- Users Table --}}
        @include('backend.users.partials.table')

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Select All Checkbox
            document.getElementById('select-all').addEventListener('change', function(e) {
                document.querySelectorAll('input[name="selected_users[]"]').forEach(cb => cb.checked = e.target
                    .checked);
            });

            // Bulk Delete Confirmation
            document.getElementById('bulkDeleteBtn').addEventListener('click', function(e) {
                e.preventDefault();
                const checked = document.querySelectorAll('input[name="selected_users[]"]:checked');

                if (checked.length === 0) {
                    Swal.fire('Error', 'Please select at least one user to delete.', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete selected users!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a hidden input with all selected IDs
                        const form = document.getElementById('bulkDeleteForm');
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_users';
                        input.value = Array.from(checked).map(cb => cb.value).join(',');
                        form.appendChild(input);

                        // Submit the form
                        form.submit();
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.delete-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // prevent immediate submit

                        const userName = this.dataset.userName || 'this user';

                        Swal.fire({
                            title: `Delete ${userName}?`,
                            text: "This action cannot be undone.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete it!',
                            reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit(); // submit the form if confirmed
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
