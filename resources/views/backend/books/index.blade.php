@extends('layouts.admin')

@section('title', 'Books Management')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <style>
        .swal2-container {
            align-items: center !important;
            justify-content: center !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">📚 Books Management</h2>
            <div>
                @can('create books')
                    <a href="{{ route('backend.books.create') }}" class="btn btn-success">➕ Add Book</a>
                @endcan
                @can('export books')
                    <a href="{{ route('backend.books.export.excel', request()->query()) }}" class="btn btn-outline-primary">📥
                        Excel</a>
                    <a href="{{ route('backend.books.export.pdf', request()->query()) }}" class="btn btn-outline-danger">📄
                        PDF</a>
                    <a href="{{ route('backend.books.print', request()->query()) }}" target="_blank"
                        class="btn btn-outline-secondary">🖨️ Print</a>
                @endcan
            </div>
        </div>

        {{-- Filter Section --}}
        <form method="GET" class="card shadow-sm mb-4 p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label">🔎 Global Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Title, Author...">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">📌 Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        @foreach (['available', 'issued', 'damaged', 'lost'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="published_from" class="form-label">📅 Published From</label>
                    <input type="text" name="published_from" id="published_from" value="{{ request('published_from') }}"
                        class="form-control" placeholder="dd/mm/yyyy" autocomplete="off">
                </div>
                <div class="col-md-2">
                    <label for="published_to" class="form-label">📅 Published To</label>
                    <input type="text" name="published_to" id="published_to" value="{{ request('published_to') }}"
                        class="form-control" placeholder="dd/mm/yyyy" autocomplete="off">
                </div>
                <div class="col-md-1">
                    <label for="per_page" class="form-label">📄 Per Page</label>
                    <select name="per_page" class="form-select">
                        @foreach ([10, 20, 50, 100, 'all'] as $size)
                            <option value="{{ $size }}" @selected(request('per_page') == $size)>
                                {{ $size == 'all' ? 'All' : $size }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-grid gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i> Apply</button>
                    <a href="{{ route('backend.books.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i>
                        Reset</a>
                </div>
            </div>
        </form>

        {{-- Books Table --}}
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            
                            <th>Title</th>
                            <th>Author</th>

                            <th>Publisher</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Cover</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->publisher }}</td>
                                <td>{{ $book->category->name ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $badgeClass = match ($book->status) {
                                            'available' => 'bg-success',
                                            'issued' => 'bg-warning text-dark',
                                            'damaged' => 'bg-danger',
                                            'lost' => 'bg-secondary',
                                            default => 'bg-light text-dark',
                                        };
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($book->status) }}
                                    </span>

                                </td>
                                <td>
                                    @if ($book->front_cover)
                                        <img src="{{ asset('storage/' . $book->front_cover) }}" class="img-thumbnail"
                                            style="width: 50px; height: auto;">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $book->price }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('view books')
                                            <a href="{{ route('backend.books.show', $book) }}" class="btn btn-info btn-sm"><i
                                                    class="bi bi-eye"></i></a>
                                        @endcan
                                        @can('edit books')
                                            <a href="{{ route('backend.books.edit', $book) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                        @endcan
                                        @can('delete books')
                                            <form action="{{ route('backend.books.destroy', $book) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Delete this book?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">📭 No books found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($books instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-center mt-4">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        flatpickr("#published_from", {
            dateFormat: "d/m/Y"
        });
        flatpickr("#published_to", {
            dateFormat: "d/m/Y"
        });
    </script>
@endpush

