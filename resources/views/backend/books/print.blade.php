<!DOCTYPE html>
<html>
<head>
    <title>Books Report</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            text-align: center;
            padding: 20px 0;
        }

        header h2 {
            margin: 0;
            font-size: 24px;
        }

        header p {
            margin: 5px 0 15px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 20px 40px;
        }

        th, td {
            border: 1px solid #444;
            padding: 8px;
            font-size: 13px;
            text-align: left;
        }

        footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 12px;
        }

        footer::after {
            content: "Page " counter(page);
        }

        .actions {
            text-align: center;
            margin: 30px 0;
        }

        .btn {
            padding: 10px 20px;
            font-size: 14px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-print {
            background-color: #28a745;
            color: white;
        }

        .btn-close {
            background-color: #dc3545;
            color: white;
        }

        /* Hide buttons when printing */
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <header>
        <h2>Books Report</h2>
        <p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
    </header>

    <table>
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Published Date</th>
                <th>Category</th>
                <th>Status</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $index => $book)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->publisher }}</td>
                    <td>{{ \Carbon\Carbon::parse($book->published_date)->format('d M Y') }}</td>
                    <td>{{ $book->category->name ?? '-' }}</td>
                    <td>{{ ucfirst($book->status) }}</td>
                    <td>{{ $book->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="actions no-print">
        <button class="btn btn-print" onclick="window.print()">Print</button>
        <button class="btn btn-close" onclick="window.close()">Close</button>
    </div>

    <footer class="no-print">
        &copy; {{ date('Y') }} Balganga Library
    </footer>
</body>
</html>
