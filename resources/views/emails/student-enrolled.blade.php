<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Enrollment Confirmation</title>
</head>
<body>
    <p>Dear {{ $student->first_name }} {{ $student->last_name }},</p>

    <p>You have successfully enrolled with our Library System.</p>
    
    <p><strong>Enrollment Number:</strong> {{ $student->enrollment_no }}<br>
    <strong>Library ID:</strong> {{ $student->student_library_id }}</p>

    <p>Please keep your library number handy while interacting with the library management system.</p>

    <p>Regards,<br>Library Team</p>
</body>
</html>
