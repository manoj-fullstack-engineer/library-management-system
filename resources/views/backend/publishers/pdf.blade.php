<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Publishers List PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 20px;
        }
        h2 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }
        .meta {
            text-align: center;
            font-size: 12px;
            margin-bottom: 15px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 6px 8px;
            vertical-align: middle;
        }
        th {
            background-color: #eee;
            text-transform: uppercase;
        }
        img.logo {
            max-width: 50px;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
        }
    </style>
</head>
<body>
    <h2>Publishers List</h2>
    <div class="meta">
        Printed on: {{ now()->format('d M Y, h:i A') }}<br/>
        Printed by: {{ auth()->user()->name ?? 'System' }}
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Country</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($publishers as $publisher)
            <tr>
                <td>{{ $publisher->id }}</td>
                <td>
                    <img src="{{ public_path('storage/' . ($publisher->logo && $publisher->logo !== 'N/A' ? $publisher->logo : 'default-publisher.png')) }}" 
                         alt="Logo" class="logo" />
                </td>
                <td>{{ $publisher->name }}</td>
                <td>{{ $publisher->email ?? '—' }}</td>
                <td>{{ $publisher->phone ?? '—' }}</td>
                <td>{{ $publisher->address ?? '—' }}</td>
                <td>{{ $publisher->country ?? '—' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($publisher->description, 100, '...') ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="no-data">No publishers found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
