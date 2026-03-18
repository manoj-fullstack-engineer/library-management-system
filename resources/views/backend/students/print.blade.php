@extends('layouts.admin')

@section('title', 'Print Students List')

@section('content')
<div class="container">
    <h2 class="my-3">Students List</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Registration No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Department</th>
                <th>Course</th>
                <th>Library Card No.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->registration_number }}</td>
                <td>{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->contact_number }}</td>
                <td>{{ $student->department }}</td>
                <td>{{ $student->course }}</td>
                <td>{{ $student->student_library_id }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>
@endsection
