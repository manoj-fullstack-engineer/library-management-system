<!DOCTYPE html>
<html>
<head>
    <title>Visitors Export</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1 class="text-center">Visitors Report</h1>
    <p class="text-right">Generated on: {{ now()->format('d/m/Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                @foreach($data[0] ?? [] as $key => $value)
                    <th>{{ $key }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    @foreach($row as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>