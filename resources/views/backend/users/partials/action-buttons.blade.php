<div class="d-flex justify-content-between align-items-center">
    <form id="bulkDeleteForm" method="POST" action="{{ route('backend.users.bulk-delete') }}">
        @csrf
        <button type="submit" id="bulkDeleteBtn" class="btn btn-danger btn-sm">
            <i class="bi bi-trash"></i> Delete Selected
        </button>
    </form>

    <div class="btn-group" role="group" aria-label="Export Options">
        <a href="{{ route('backend.users.export.excel', request()->all()) }}" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </a>
        <a href="{{ route('backend.users.export.pdf', request()->all()) }}" class="btn btn-danger btn-sm">
            <i class="bi bi-file-earmark-pdf"></i> PDF
        </a>
        <a href="{{ route('backend.users.print', request()->all()) }}" class="btn btn-secondary btn-sm" target="_blank">
            <i class="bi bi-printer"></i> Print
        </a>
    </div>
</div>