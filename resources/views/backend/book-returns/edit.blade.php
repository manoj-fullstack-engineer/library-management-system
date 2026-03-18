@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Edit Book Return</h4>
    <a href="{{ route('backend.book-returns.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

{{-- ✅ Show Validation/Error Messages --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('backend.book-returns.update', $bookReturn->id) }}" method="POST" class="card card-body shadow-sm">
    @csrf
    @method('PUT')

    <div class="row g-3">
        {{-- Book ID --}}
        <div class="col-md-6">
            <label for="book_id_input" class="form-label">Book ID <span class="text-danger">*</span></label>
            <input type="text" id="book_id_input" name="book_id" class="form-control" required readonly value="{{ $bookReturn->book_id }}">
        </div>

        {{-- Auto-filled Book Info --}}
        <div class="col-md-6">
            <label class="form-label">Book Title</label>
            <input type="text" id="book_title" class="form-control" readonly value="{{ $bookReturn->book->title ?? 'N/A' }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Book Status</label>
            <input type="text" id="book_status" class="form-control" readonly value="{{ $bookReturn->book->status ?? 'N/A' }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Issued By (Librarian)</label>
            <input type="text" id="issued_by" class="form-control" readonly value="{{ $bookReturn->librarian->name ?? '-' }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Issue Date</label>
            <input type="date" id="issue_date" name="issue_date" class="form-control" readonly value="{{ \Carbon\Carbon::parse($bookReturn->issue_date)->format('Y-m-d') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Issued To (Student ID)</label>
            <input type="text" id="student_library_id" name="student_library_id" class="form-control" readonly value="{{ $bookReturn->student_library_id }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Student Name</label>
            <input type="text" id="student_name" class="form-control" readonly value="{{ $bookReturn->student->full_name ?? 'N/A' }}">
        </div>

        {{-- Return Info --}}
        <div class="col-md-4">
            <label for="return_date" class="form-label">Return Date <span class="text-danger">*</span></label>
            <input type="date" name="return_date" id="return_date" class="form-control" required value="{{ \Carbon\Carbon::parse($bookReturn->return_date)->format('Y-m-d') }}">
        </div>

        <div class="col-md-4">
            <label for="condition_on_return" class="form-label">Condition on Return</label>
            <select name="condition_on_return" id="condition_on_return" class="form-select">
                <option value="">-- Select --</option>
                <option value="Good" {{ $bookReturn->condition_on_return == 'Good' ? 'selected' : '' }}>Good</option>
                <option value="Damaged" {{ $bookReturn->condition_on_return == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                <option value="Lost" {{ $bookReturn->condition_on_return == 'Lost' ? 'selected' : '' }}>Lost</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="fine_amount" class="form-label">Fine (₹)</label>
            <input type="number" step="0.01" name="fine_amount" id="fine_amount" class="form-control" value="{{ $bookReturn->fine_amount }}">
        </div>

        <div class="col-md-12">
            <label for="remark" class="form-label">Remarks</label>
            <textarea name="remark" id="remark" class="form-control" rows="2" placeholder="Optional remark">{{ $bookReturn->remark }}</textarea>
        </div>

        <div class="col-12 text-end mt-3">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check-circle me-1"></i> Update Return
            </button>
        </div>
    </div>
</form>
@endsection
