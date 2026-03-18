@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        {{-- 🔠 Page Title & Actions --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0 text-primary">📇 Library Cards</h3>
            <div class="btn-group">
                <a href="{{ route('backend.library-cards.export.pdf') }}" class="btn btn-outline-danger">
                    ⬇️ PDF
                </a>
                <a href="{{ route('backend.library-cards.create') }}" class="btn btn-success">
                    ➕ New Card
                </a>
            </div>
        </div>

        {{-- 🔍 Search --}}
        <form method="GET" action="{{ route('backend.library-cards.index') }}" class="mb-4">
            <div class="input-group shadow-sm">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Search by student name, ID or library ID...">
                <button class="btn btn-outline-primary" type="submit">🔍 Search</button>
            </div>
        </form>

        {{-- 📋 Table --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-center text-uppercase small">
                                <th>Card No</th>
                                <th>Lib ID</th>
                                <th>Student</th>
                                <th>Issued On</th>
                                <th>Count</th>
                                <th>Issued By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($libraryCards as $card)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $card->card_number }}</td>
                                    <td class="text-center">{{ $card->student->student_library_id }}</td>
                                    <td>{{ $card->student->first_name }} {{ $card->student->last_name }}</td>
                                    <td class="text-center">{{ $card->issued_on->format('d M Y') }}</td>
                                    <td class="text-center">{{ $card->issued_count }}</td>
                                    <td>{{ $card->issued_by }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('backend.library-cards.print', $card->id) }}"
                                            class="btn btn-sm btn-outline-secondary" target="_blank" title="Print">
                                            🖨️
                                        </a>
                                        <form action="{{ route('backend.library-cards.send.pdf', $card->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-info"
                                                title="Send PDF via Email">
                                                📧
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- 🔢 Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $libraryCards->links() }}
        </div>
    </div>
@endsection
