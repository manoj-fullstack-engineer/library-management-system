<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Card</title>
    <style>
        :root {
            --primary: #2F3C7E;
            --secondary: #FBEAEB;
            --text-dark: #333;
            --text-light: #555;
            --border: #dcdcdc;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px 0;
        }

        .card-box {
            width: 700px;
            background: #fff;
            border: 1px solid var(--border);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 30px 25px 40px;
            margin: auto;
            position: relative;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
            width: 80px;
            height: 80px;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        h2 {
            text-align: center;
            color: var(--primary);
            font-weight: 600;
            font-size: 24px;
        }

        .photo-box {
            position: absolute;
            top: 30px;
            right: 30px;
            border: 2px solid var(--border);
            border-radius: 8px;
            width: 100px;
            height: 120px;
            overflow: hidden;
            background: #fafafa;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 180px auto;
            row-gap: 12px;
            column-gap: 10px;
            color: var(--text-dark);
            font-size: 15px;
            margin-top: 20px;
        }

        .info-grid .label {
            font-weight: 600;
            color: var(--text-light);
        }

        .footer-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .signature-box,
        .stamp-box {
            font-size: 14px;
            color: var(--text-light);
            text-align: center;
        }

        .signature-box {
            flex: 1;
        }

        .stamp-box {
            flex: 1;
        }

        .stamp {
            width: 100px;
            height: auto;
            margin-top: 5px;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 15px;
            border: none;
            border-radius: 6px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-print {
            background: var(--primary);
        }

        .btn-print:hover {
            background: #1d2b5e;
        }

        .btn-exit {
            background: #999;
        }

        .btn-exit:hover {
            background: #555;
        }

        @media print {
            .button-group {
                display: none;
            }

            body {
                background: white;
                padding: 0;
            }

            .card-box {
                box-shadow: none;
                border: none;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="card-box">
        {{-- Header --}}
        <div class="header">
            <div class="logo">
                <img src="{{ asset('images/university-logo.png') }}" alt="University Logo">
            </div>
            <h2>📇 Library Card</h2>
        </div>

        {{-- Photo --}}
        <div class="photo-box">
            @if ($libraryCard->student->photo)
                <img src="{{ asset('storage/' . $libraryCard->student->photo) }}" alt="Student Photo">
            @else
                <img src="{{ asset('images/default-user.png') }}" alt="No Photo">
            @endif
        </div>

        {{-- Student Info --}}
        <div class="info-grid">
            <div class="label">Card No:</div>
            <div>{{ $libraryCard->card_number }}</div>
            <div class="label">Student ID:</div>
            <div>{{ $libraryCard->student->student_library_id }}</div>
            <div class="label">Name:</div>
            <div>{{ $libraryCard->student->first_name }} {{ $libraryCard->student->last_name }}</div>
            <div class="label">Gender:</div>
            <div>{{ ucfirst($libraryCard->student->gender) }}</div>
            <div class="label">Contact:</div>
            <div>{{ $libraryCard->student->contact_number }}</div>
            <div class="label">Enrollment No:</div>
            <div>{{ $libraryCard->student->enrollment_no }}</div>
            <div class="label">Enrollment Date:</div>
            <div>{{ \Carbon\Carbon::parse($libraryCard->student->enrollment_date)->format('d M Y') }}</div>
            <div class="label">Department:</div>
            <div>{{ $libraryCard->student->department }}</div>
            <div class="label">Course:</div>
            <div>{{ $libraryCard->student->course }}</div>
            <div class="label">Year/Semester:</div>
            <div>{{ $libraryCard->student->year_semester }}</div>
            <div class="label">Address:</div>
            <div>{{ $libraryCard->student->address }}</div>
            <div class="label">Issued On:</div>
            <div>{{ $libraryCard->issued_on->format('d M Y') }}</div>
            <div class="label">Times Issued:</div>
            <div>{{ $libraryCard->issued_count }}</div>
            <div class="label">Issued By:</div>
            <div>{{ $libraryCard->issued_by }}</div>
        </div>

        {{-- Footer Section --}}
        <div class="footer-section">
            <div class="signature-box">
                ___________________________<br>
                <strong>Librarian Signature</strong>
            </div>
            <div class="stamp-box">
                <strong>Library Seal</strong><br>
                <img src="{{ asset('images/library-stamp.png') }}" alt="Stamp" class="stamp">
            </div>
        </div>

        {{-- Buttons --}}
        <div class="button-group">
            <button onclick="window.print()" class="btn btn-print">🖨️ Print</button>
            <button onclick="closeWindow()" class="btn btn-exit">❌ Exit</button>
        </div>
    </div>

    <script>
        function closeWindow() {
            if (confirm("Are you sure you want to close this tab?")) {
                window.open('', '_self');
                window.close();
            }
        }
    </script>
</body>
</html>
