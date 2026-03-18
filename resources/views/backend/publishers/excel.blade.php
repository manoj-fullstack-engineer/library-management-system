<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: sans-serif;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
        }
        img.logo {
            width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    <h3>📚 Publishers List</h3>
    <p><strong>Exported at:</strong> {{ now()->format('d-m-Y h:i A') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                {{-- <th>Logo</th> --}}
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Country</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($publishers as $publisher)
                <tr>
                    <td>{{ $publisher->id }}</td>
                    {{-- <td>
                        <img class="logo"
                             src="{{ public_path('storage/' . ($publisher->logo !== 'N/A' ? $publisher->logo : 'default.png')) }}"
                             alt="Logo">
                    </td> --}}
                    <td>{{ $publisher->name }}</td>
                    <td>{{ $publisher->email ?? '—' }}</td>
                    <td>{{ $publisher->phone ?? '—' }}</td>
                    <td>{{ $publisher->address ?? '—' }}</td>
                    <td>{{ $publisher->country ?? '—' }}</td>
                    <td>{{ $publisher->description ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
