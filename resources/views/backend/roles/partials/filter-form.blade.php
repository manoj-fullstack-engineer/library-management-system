<div class="card mb-4 shadow-sm border-0">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('backend.roles.index') }}" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search roles...">
            </div>
            <div class="col-md-2">
                <input type="text" name="start_date" value="{{ request('start_date') }}" class="form-control datepicker" placeholder="From date">
            </div>
            <div class="col-md-2">
                <input type="text" name="end_date" value="{{ request('end_date') }}" class="form-control datepicker" placeholder="To date">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="fas fa-filter me-2"></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('backend.roles.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-sync-alt me-2"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>