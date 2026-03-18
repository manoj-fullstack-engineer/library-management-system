<p class="text-danger">DEBUG: {{ $bookIssue->id ?? 'not set' }}</p>

@extends('layouts.admin')
@section('title', 'Edit Book Issue')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">✏️ Edit Issued Book</div>
            <div class="card-body">
                <p class="text-danger">DEBUG: {{ $bookIssue->id ?? 'NOT SET' }}</p>

                <form action="{{ route('backend.book-issues.update', ['bookIssue' => $bookIssue]) }}" method="POST">


                    @csrf
                    @method('PUT')

                    @include('backend.book-issues._tab_issue', ['bookIssue' => $bookIssue])

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.book-issues.index') }}" class="btn btn-secondary">← Exit</a>
                        <button type="submit" class="btn btn-primary">💾 Update Issue</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Check for Overdue Alert --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dueDate = "{{ $bookIssue->due_date ?? '' }}";
            const returnedAt = "{{ $bookIssue->returned_at ?? '' }}";

            if (dueDate && !returnedAt) {
                const isOverdue = new Date() > new Date(dueDate);
                if (isOverdue) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Overdue Book',
                        text: '⚠️ This book is overdue! Please return immediately.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                }
            }
        });
    </script>

    {{-- SweetAlert Notifications --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validation Failed',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                customClass: {
                    popup: 'text-start'
                }
            });
        </script>
    @endif
@endpush
