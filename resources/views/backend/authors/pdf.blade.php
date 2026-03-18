<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Authors PDF Export</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            text-transform: uppercase;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #999;
        }
    </style>
</head>
<body>
    <h2>Authors List</h2>

    <table>
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $index => $author)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
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
