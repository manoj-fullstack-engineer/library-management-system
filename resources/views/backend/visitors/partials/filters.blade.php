<div class="row mb-3">
    <div class="col-md-2">
        <input type="text" id="from_date" class="form-control datepicker" placeholder="From Date (DD/MM/YYYY)">
    </div>
    <div class="col-md-2">
        <input type="text" id="to_date" class="form-control datepicker" placeholder="To Date (DD/MM/YYYY)">
    </div>
    <div class="col-md-8 d-flex flex-wrap gap-2">
        <button id="filter" class="btn btn-primary">
            <i class="fas fa-filter me-1"></i> Filter
        </button>
        <button id="reset" class="btn btn-outline-secondary">
            <i class="fas fa-sync-alt me-1"></i> Show All
        </button>
        <a href="#" id="exportExcel" class="btn btn-success">
            <i class="fas fa-file-excel me-1"></i> Export Excel
        </a>
        <a href="#" id="exportPdf" class="btn btn-danger">
            <i class="fas fa-file-pdf me-1"></i> Export PDF
        </a>
        <a href="#" id="printData" target="_blank" class="btn btn-secondary">
            <i class="fas fa-print me-1"></i> Print
        </a>
    </div>
</div>
