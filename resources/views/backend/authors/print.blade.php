<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Authors List</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px 20px 20px;
            background-color: #fff;
            color: #333;
        }

        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            z-index: 1000;
        }

        .top-bar button {
            padding: 6px 12px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .top-bar button.exit-btn {
            background-color: #dc3545;
        }

        h2 {
            text-align: center;
            margin-top: 60px;
            margin-bottom: 20px;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #e9ecef;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        @media print {
            .top-bar {
                display: none;
            }

            h2 {
                margin-top: 0;
            }
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <button onclick="window.print()">🖨️ Print</button>
        <button class="exit-btn" onclick="window.close()">❌ Exit</button>
    </div>

    <h2>Authors List</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $index => $author)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $author->name }}</td>
                <td>{{ $author->email ?? '—' }}</td>
                <td>{{ $author->phone ?? '—' }}</td>
                <td>{{ $author->country ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
