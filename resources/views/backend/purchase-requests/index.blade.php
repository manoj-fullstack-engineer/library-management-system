@extends('layouts.admin')

@section('title', 'Purchase Requests')

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
            <h2 class="mb-0">📝 Purchase Requests</h2>
            <a href="{{ route('backend.purchase-requests.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Request
            </a>
        </div>


        {{-- Filter Form --}}
        <form method="GET" action="{{ route('backend.purchase-requests.index') }}" class="card border-0 shadow p-4 mb-4">
            <div class="row g-3 align-items-end">
                {{-- Item Name --}}
                <div class="col-md-3">
                    <label for="item_name" class="form-label fw-semibold">Item Name</label>
                    <input type="text" name="item_name" id="item_name" value="{{ request('item_name') }}"
                        class="form-control shadow-sm" placeholder="Search by item...">
                </div>

                {{-- Requester --}}
                <div class="col-md-3">
                    <label for="requester_id" class="form-label fw-semibold">Requester</label>
                    <select name="requester_id" id="requester_id" class="form-select shadow-sm">
                        <option value="">-- All --</option>
                        @foreach (App\Models\User::pluck('name', 'id') as $id => $name)
                            <option value="{{ $id }}" {{ request('requester_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="col-md-2">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select name="status" id="status" class="form-select shadow-sm">
                        <option value="">-- All --</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                {{-- From Date --}}
                <div class="col-md-2">
                    <label for="from_date" class="form-label fw-semibold">From Date</label>
                    <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                        class="form-control shadow-sm">
                </div>

                {{-- To Date --}}
                <div class="col-md-2">
                    <label for="to_date" class="form-label fw-semibold">To Date</label>
                    <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                        class="form-control shadow-sm">
                </div>

                {{-- Action Buttons --}}
                <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Apply Filters
                    </button>
                    <a href="{{ route('backend.purchase-requests.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        {{-- Export + Print --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Filtered Results</h4>

            <div>
                <a href="{{ route('backend.purchase-requests.print', request()->query()) }}" target="_blank"
                    class="btn btn-outline-secondary btn-sm">
                    🖨️ Print
                </a>

                <a href="{{ route('backend.purchase-requests.export.pdf', request()->query()) }}"
                    class="btn btn-outline-danger btn-sm">
                    📄 Export PDF
                </a>

                <a href="{{ route('backend.purchase-requests.export.excel', request()->query()) }}"
                    class="btn btn-outline-success btn-sm">
                    📊 Export Excel
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Req No</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Estimated Cost</th>
                            <th>Requested By</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchaseRequests  as $index => $request)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $request->request_number }}</td>
                                <td>{{ $request->item_name }}</td>
                                <td>{{ $request->quantity }}</td>
                                <td>₹{{ number_format($request->estimated_cost, 2) }}</td>
                                <td>{{ $request->requester->name ?? '-' }}</td>
                                <td>{{ $request->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $request->status === 'approved' ? 'success' : ($request->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                
                                    {{-- Always visible actions --}}
                                <td class="text-nowrap">
                                    {{-- Common Actions --}}
                                    <a href="{{ route('backend.purchase-requests.show', $request) }}"
                                        class="btn btn-outline-info btn-sm me-1" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('backend.purchase-requests.edit', $request) }}"
                                        class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('backend.purchase-requests.destroy', $request) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure to delete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm me-1" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                    {{-- Admin-only Approve/Reject --}}
                                    @role('SuperAdmin')
                                        @if ($request->status === 'pending')
                                            <form action="{{ route('backend.purchase-requests.approve', $request->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Approve this request?')">
                                                @csrf @method('PUT')
                                                <button class="btn btn-outline-success btn-sm me-1" title="Approve">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('backend.purchase-requests.reject', $request->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Reject this request?')">
                                                @csrf @method('PUT')
                                                <button class="btn btn-outline-danger btn-sm" title="Reject">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endrole
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $purchaseRequests->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
