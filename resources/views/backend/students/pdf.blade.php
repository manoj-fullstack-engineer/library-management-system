
@section('content')
<h2 style="text-align:center;">Students List</h2>
<table border="1" cellspacing="0" cellpadding="5" width="100%" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th>Registration No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Department</th>
            <th>Course</th>
            <th>Library ID</th>
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
@endsection
