<!DOCTYPE html>
<html>
<head>
    <title>Books PDF</title>
    <style>
        @page {
            margin: 100px 40px;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
        }

        .footer .page::after {
            content: counter(page);
        }

        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #888;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
        }
    </style>
</head>
<body>

<header>
    Library Report - Books List<br>
    Generated on: {{ now()->format('d M Y, h:i A') }}
</header>

<footer>
    Printed by Library System — Page <span class="page"></span>
</footer>

<main>
    <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
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
            @foreach ($books as $index => $book)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->publisher }}</td>
                    <td>{{ $book->published_date?->format('d M Y') }}</td>
                    <td>{{ $book->category->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($book->status) }}</td>
                    <td>{{ $book->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        _______________________ <br>
        Librarian Signature
    </div>
</main>

</body>
</html>
