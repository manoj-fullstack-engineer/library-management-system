@extends('layouts.admin')

@section('title', 'Return Book')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4"><i class="bi bi-arrow-return-left me-1"></i> Return Issued Book</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <form method="POST" action="{{ route('backend.book-issues.return.update', $bookIssue->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    {{-- Student Info --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">📘 Student Library ID</label>
                        <input type="text" class="form-control" value="{{ $bookIssue->student_library_id }}" readonly>
                    </div>

                    {{-- Book Info --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">📗 Book ID</label>
                        <input type="text" class="form-control" value="{{ $bookIssue->book_id }}" readonly>
                    </div>

                    {{-- Issued Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">📅 Issued On</label>
                        <input type="text" class="form-control" value="{{ $bookIssue->issued_at?->format('d/m/Y H:i') }}" readonly>
                    </div>

                    {{-- Due Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">⏳ Due Date</label>
                        <input type="text" class="form-control" value="{{ $bookIssue->due_date?->format('d/m/Y') }}" readonly>
                    </div>

                    {{-- Remark --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">📝 Remark</label>
                        <textarea class="form-control" rows="3" readonly>{{ $bookIssue->remark }}</textarea>
                    </div>

                    {{-- Return Button --}}
                    <div class="col-12 text-end">
                        @if(!$bookIssue->returned_at)
                            <button type="submit" class="btn btn-success px-4">🔁 Confirm Return</button>
                        @else
                            <button type="button" class="btn btn-outline-secondary px-4" disabled>Already Returned</button>
                        @endif
                        <a href="{{ route('backend.book-issues.index') }}" class="btn btn-secondary px-4 ms-2">↩ Back</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
