<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Card</title>
    <style>
        @page {
            margin: 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            background: #f9f9f9;
        }

        .card-container {
            background: #ffffff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            position: relative;
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 70px;
        }

        .logo img {
            width: 70px;
            height: auto;
        }

        .photo-box {
            position: absolute;
            top: 0;
            right: 0;
            width: 70px;
            height: 90px;
            border: 1px solid #ccc;
            background: #f0f0f0;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        h2 {
            font-size: 20px;
            color: #2F3C7E;
            margin: 0;
        }

        .info-table {
            width: 100%;
            margin-top: 120px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            color: #555;
            width: 160px;
        }

        .footer-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box, .stamp-box {
            text-align: center;
            font-size: 11px;
            color: #555;
        }

        .signature-line {
            margin-top: 20px;
            border-top: 1px solid #333;
            width: 120px;
            margin-left: auto;
            margin-right: auto;
        }

        .stamp {
            width: 80px;
            margin-top: 5px;
        }

        .highlight {
            background: #FBEAEB;
            padding: 6px;
            border-radius: 5px;
        }

    </style>
</head>
<body>
    <div class="card-container">
        <div class="header">
            <div class="logo">
                <img src="{{ public_path('images/university-logo.png') }}" alt="Logo">
            </div>
            <h2>📇 Library Card</h2>
            <div class="photo-box">
                @if ($libraryCard->student->photo && file_exists(public_path('storage/'.$libraryCard->student->photo)))
                    <img src="{{ public_path('storage/' . $libraryCard->student->photo) }}" alt="Student Photo">
                @else
                    <img src="{{ public_path('images/default-user.png') }}" alt="No Photo">
                @endif
            </div>
        </div>

        <table class="info-table">
            <tr><td class="label">Card No:</td><td class="highlight">{{ $libraryCard->card_number }}</td></tr>
            <tr><td class="label">Student ID:</td><td>{{ $libraryCard->student->student_library_id }}</td></tr>
            <tr><td class="label">Name:</td><td>{{ $libraryCard->student->first_name }} {{ $libraryCard->student->last_name }}</td></tr>
            <tr><td class="label">Gender:</td><td>{{ ucfirst($libraryCard->student->gender) }}</td></tr>
            <tr><td class="label">Contact:</td><td>{{ $libraryCard->student->contact_number }}</td></tr>
            <tr><td class="label">Enrollment No:</td><td>{{ $libraryCard->student->enrollment_no }}</td></tr>
            <tr><td class="label">Enrollment Date:</td><td>{{ \Carbon\Carbon::parse($libraryCard->student->enrollment_date)->format('d M Y') }}</td></tr>
            <tr><td class="label">Department:</td><td>{{ $libraryCard->student->department }}</td></tr>
            <tr><td class="label">Course:</td><td>{{ $libraryCard->student->course }}</td></tr>
            <tr><td class="label">Year/Semester:</td><td>{{ $libraryCard->student->year_semester }}</td></tr>
            <tr><td class="label">Address:</td><td>{{ $libraryCard->student->address }}</td></tr>
            <tr><td class="label">Issued On:</td><td>{{ $libraryCard->issued_on->format('d M Y') }}</td></tr>
            <tr><td class="label">Times Issued:</td><td>{{ $libraryCard->issued_count }}</td></tr>
            <tr><td class="label">Issued By:</td><td>{{ $libraryCard->issued_by }}</td></tr>
        </table>

        <div class="footer-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                Librarian Signature
            </div>
            <div class="stamp-box">
                Library Seal<br>
                <img src="{{ public_path('images/library-stamp.png') }}" class="stamp" alt="Stamp">
            </div>
        </div>
    </div>
</body>
</html>
