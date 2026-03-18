@extends('layouts.admin')

@section('title', 'Stock Inventory')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">📦 Stock Inventory</h1>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filters --}}
        <form action="{{ route('backend.stocks.index') }}" method="GET" class="row g-2 align-items-end mb-4">
            <div class="col-md-2">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Item Name">
            </div>
            <div class="col-md-2">
                <select name="inventory_category_id" class="form-select">
                    <option value="">-- Category --</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}" {{ request('inventory_category_id') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="vendor" value="{{ request('vendor') }}" class="form-control"
                    placeholder="Vendor Name">
            </div>
            <div class="col-md-2">
                <input type="date" name="from" value="{{ request('from') }}" class="form-control" placeholder="From">
            </div>
            <div class="col-md-2">
                <input type="date" name="to" value="{{ request('to') }}" class="form-control" placeholder="To">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('backend.stocks.index') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>


        {{-- Export & Add --}}
     

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('backend.stocks.export.pdf', request()->query()) }}" class="btn btn-danger btn-sm">📄
                    Export PDF</a>
                <a href="{{ route('backend.stocks.export.excel', request()->query()) }}" class="btn btn-success btn-sm">📊
                    Export Excel</a>
                <a href="{{ route('backend.stocks.print', request()->query()) }}" target="_blank"
                    class="btn btn-dark btn-sm">🖨️ Print</a>
                <a href="{{ route('backend.stocks.create') }}" class="btn btn-primary btn-sm">➕ Add New Stock</a>
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Vendor</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Created By</th>
                            <th>Bill</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stocks as $index => $stock)
                            <tr>
                                <td>{{ $stocks->firstItem() + $index }}</td>
                                <td>{{ $stock->item_name }}</td>
                                <td>{{ $stock->category->name ?? '-' }}</td>
                                <td>{{ $stock->vendor }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>₹{{ number_format($stock->amount, 2) }}</td>
                                <td>{{ $stock->creator->name ?? 'System' }}</td>
                                <td>
                                    @if ($stock->bill_file_path)
                                        <a href="{{ route('backend.stocks.viewBill', $stock->id) }}"
                                            class="btn btn-outline-secondary btn-sm" target="_blank">📄 View</a>
                                    @else
                                        <span class="text-muted">No File</span>
                                    @endif
                                </td>
                                <td>{{ $stock->created_at->format('d M Y, h:i A') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('backend.stocks.edit', $stock->id) }}"
                                        class="btn btn-warning btn-sm px-2 py-1 fs-6">✏️</a>
                                    <form action="{{ route('backend.stocks.destroy', $stock->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this stock?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-2 py-1 fs-6">🗑️</button>
                                    </form>
                                    <a href="{{ route('backend.stocks.show', $stock->id) }}"
                                        class="btn btn-info btn-sm px-2 py-1 fs-6">🔍</a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">No stock entries found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $stocks->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
