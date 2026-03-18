@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Issue Library Card</h4>
    <form method="POST" action="{{ route('backend.library-cards.store') }}">
        @csrf
        <div class="form-group">
            <label for="student_id">Select Student:</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <option value="">-- Select Student --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_library_id }})
                    </option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success mt-3">Issue Card</button>
    </form>
</div>
@endsection
