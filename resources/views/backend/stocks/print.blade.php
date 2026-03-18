@extends('layouts.print')

@section('title', 'Stock Report')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>📦 Stock Report</h2>
        <div>
            <button class="btn btn-outline-primary btn-sm me-2" onclick="window.print()">
                🖨️ Print
            </button>
            <a href="{{ route('backend.stocks.index') }}" class="btn btn-outline-secondary btn-sm">
                ❌ Exit
            </a>
        </div>
    </div>

    <p>
        <strong>Printed At:</strong> {{ now()->format('d M Y, h:i A') }}<br>
        <strong>Printed By:</strong> {{ auth()->user()->name }}
    </p>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Vendor</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Created By</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->item_name }}</td>
                    <td>{{ $s->category->name ?? '-' }}</td>
                    <td>{{ $s->vendor_name }}</td>
                    <td>{{ $s->quantity }}</td>
                    <td>₹{{ number_format($s->amount, 2) }}</td>
                    <td>{{ $s->creator->name ?? 'System' }}</td>
                    <td>{{ $s->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #ffffcc; font-weight: bold;">
                <td colspan="4">Total Items: {{ $stocks->count() }}</td>
                <td>{{ $stocks->sum('quantity') }}</td>
                <td>₹{{ number_format($stocks->sum('amount'), 2) }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
