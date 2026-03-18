<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Student ID</th>
            <th>Book ID</th>
            <th>Return Date</th>
            <th>Condition</th>
            <th>Fine (₹)</th>
            <th>Remark</th>
        </tr>
    </thead>
    <tbody>
        @php $totalFine = 0; @endphp
        @foreach($returns as $index => $log)
            @php $totalFine += $log->fine_amount; @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $log->student_library_id }}</td>
                <td>{{ $log->book_id }}</td>
                <td>{{ \Carbon\Carbon::parse($log->return_date)->format('d M Y, h:i A') }}</td>
                <td>{{ $log->book_condition }}</td>
                <td>{{ number_format($log->fine_amount, 2) }}</td>
                <td>{{ $log->return_remark }}</td>
            </tr>
        @endforeach
    </tbody>
    @if($returns->count())
    <tfoot>
        <tr>
            <td colspan="5"><strong>Total Fine</strong></td>
            <td colspan="2"><strong>₹ {{ number_format($totalFine, 2) }}</strong></td>
        </tr>
    </tfoot>
    @endif
</table>
