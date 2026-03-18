@extends('layouts.print')

@section('title', 'Publishers Print View')

@section('styles')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            color: #333;
            background: #fff;
            padding: 30px;
        }

        h3 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 10px;
            font-size: 24px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .btn-group-print {
            position: fixed;
            top: 20px;
            right: 30px;
            z-index: 999;
        }

        .btn-group-print .btn {
            margin-left: 10px;
        }

        .meta-info {
            margin-bottom: 10px;
            font-size: 14px;
            text-align: center;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            vertical-align: middle;
        }

        th {
            background-color: #f8f8f8;
            text-transform: uppercase;
        }

        .logo-thumbnail {
            max-width: 50px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
    </style>
@endsection

@section('content')
    <div class="btn-group-print no-print">
        <button onclick="window.print()" class="btn btn-success">🖨️ Print</button>
        <button onclick="exitPrintView()" class="btn btn-danger">❌ Exit</button>
    </div>

    <h3>Publishers List</h3>

    <div class="meta-info">
        Printed on {{ now()->format('d M Y, h:i A') }} <br>
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
                        <img src="{{ $publisher->logo && $publisher->logo !== 'N/A' ? asset('storage/' . $publisher->logo) : asset('images/default-publisher.png') }}"
                             alt="Logo" class="logo-thumbnail">
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
                    <td colspan="8" class="text-center">No publishers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
    function exitPrintView() {
        // Try closing the window (works if tab was opened via script)
        window.close();

        // If window not closed, fallback to referrer or homepage
        setTimeout(() => {
            if (!window.closed) {
                if (document.referrer) {
                    window.location.href = document.referrer;
                } else {
                    window.location.href = '/'; // fallback URL (change as needed)
                }
            }
        }, 200);
    }
</script>
@endsection
