<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Category</th>
            <th>Vendor</th>
            <th>Qty</th>
            <th>Amount</th>
            <th>Created By</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stocks as $index => $s)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $s->item_name }}</td>
            <td>{{ $s->category->name ?? '-' }}</td>
            <td>{{ $s->vendor_name }}</td>
            <td>{{ $s->quantity }}</td>
            <td>{{ $s->amount }}</td>
            <td>{{ $s->creator->name ?? 'System' }}</td>
            <td>{{ $s->created_at->format('d-m-Y') }}</td>
        </tr>
        @endforeach

        {{-- ✅ Summary Row --}}
        <tr style="background-color: #F9CB9C; font-weight: bold;">
            <td colspan="4">Total Items: {{ $itemCount }}</td>
            <td>{{ $totalQuantity }}</td>
            <td>₹{{ number_format($totalAmount, 2) }}</td>
            <td colspan="2">Grand Total: ₹{{ number_format($grandTotal, 2) }}</td>
        </tr>
    </tbody>
</table>
