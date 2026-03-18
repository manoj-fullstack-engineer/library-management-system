@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Edit Visitor</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('backend.visitors.update', $visitor->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $visitor->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $visitor->email) }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $visitor->phone) }}">
        </div>

        <div class="mb-3">
            <label for="ip_address" class="form-label">IP Address</label>
            <input type="text" id="ip_address" name="ip_address" class="form-control" value="{{ old('ip_address', $visitor->ip_address) }}">
        </div>

        <div class="mb-3">
            <label for="visited_at" class="form-label">Visited At</label>
            <input type="text" id="visited_at" name="visited_at" class="form-control datepicker" value="{{ old('visited_at', optional($visitor->visited_at)->format('d/m/Y')) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Visitor</button>
        <a href="{{ route('backend.visitors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(function () {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
@endsection
