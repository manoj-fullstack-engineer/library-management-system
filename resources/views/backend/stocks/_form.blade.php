@csrf

<div class="row g-3">
    {{-- Item Name --}}
    <div class="col-md-6">
        <label for="item_name" class="form-label">Item Name <span class="text-danger">*</span></label>
        <input type="text" name="item_name" id="item_name"
            class="form-control @error('item_name') is-invalid @enderror"
            value="{{ old('item_name', $stock->item_name ?? '') }}" required>
        @error('item_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Category --}}
    <div class="col-md-6">
        <label for="inventory_category_id" class="form-label">Category <span class="text-danger">*</span></label>
        <select name="inventory_category_id" id="inventory_category_id"
            class="form-select @error('inventory_category_id') is-invalid @enderror" required>
            <option value="">-- Select Category --</option>
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}" {{ old('inventory_category_id', $stock->inventory_category_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        @error('inventory_category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Quantity --}}
    <div class="col-md-4">
        <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
        <input type="number" name="quantity" id="quantity"
            class="form-control @error('quantity') is-invalid @enderror"
            value="{{ old('quantity', $stock->quantity ?? '') }}" required>
        @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Amount --}}
    <div class="col-md-4">
        <label for="amount" class="form-label">Amount (₹) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" name="amount" id="amount"
            class="form-control @error('amount') is-invalid @enderror"
            value="{{ old('amount', $stock->amount ?? '') }}" required>
        @error('amount')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Vendor Name --}}
    <div class="col-md-4">
        <label for="vendor" class="form-label">Vendor Name</label>
        <input type="text" name="vendor" id="vendor"
            class="form-control @error('vendor') is-invalid @enderror"
            value="{{ old('vendor', $stock->vendor ?? '') }}">
        @error('vendor')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Bill Upload --}}
    <div class="col-md-6">
        <label for="bill_file_path" class="form-label">Bill File (PDF/Image)</label>
        <input type="file" name="bill_file_path" id="bill_file_path"
            class="form-control @error('bill_file_path') is-invalid @enderror"
            accept=".pdf,image/*" onchange="previewBillFile(event)">
        @error('bill_file_path')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        {{-- Live Preview --}}
        <div id="billPreview" class="mt-3 d-none">
            <div class="border p-2 rounded">
                <strong class="d-block mb-2">Preview:</strong>
                <div id="previewContent" class="mb-2"></div>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="openFullscreenPreview()">
                    🔍 Fullscreen
                </button>
            </div>
        </div>

        {{-- Existing File (if any) --}}
        {{-- @if (!empty($stock?->bill_file_path))
            <div class="mt-2">
                <a href="{{ asset('storage/' . $stock->bill_file_path) }}" target="_blank" class="text-decoration-underline">
                    📎 View Existing Bill
                </a>
            </div>
        @endif --}}
    </div>

    {{-- Remark --}}
    <div class="col-md-6">
        <label for="remark" class="form-label">Remark</label>
        <textarea name="remark" id="remark"
            class="form-control @error('remark') is-invalid @enderror"
            rows="3">{{ old('remark', $stock->remark ?? '') }}</textarea>
        @error('remark')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- Fullscreen Preview Modal --}}
<div class="modal fade" id="billFullscreenModal" tabindex="-1" aria-labelledby="billFullscreenLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">📄 Fullscreen Bill Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="fullscreenPreviewContent">
                <!-- Preview will be injected here -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewBillFile(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('billPreview');
        const previewContent = document.getElementById('previewContent');
        const fullscreenContent = document.getElementById('fullscreenPreviewContent');

        if (!file) {
            previewContainer.classList.add('d-none');
            previewContent.innerHTML = '';
            fullscreenContent.innerHTML = '';
            return;
        }

        const fileURL = URL.createObjectURL(file);
        let previewHTML = '';

        if (file.type.startsWith('image/')) {
            previewHTML = `<img src="${fileURL}" class="img-fluid rounded border" style="max-height: 300px;">`;
        } else if (file.type === 'application/pdf') {
            previewHTML = `<embed src="${fileURL}" type="application/pdf" width="100%" height="300px" class="border rounded" />`;
        } else {
            previewHTML = `<p class="text-danger">Unsupported file type</p>`;
        }

        previewContent.innerHTML = previewHTML;
        fullscreenContent.innerHTML = previewHTML;
        previewContainer.classList.remove('d-none');
    }

    function openFullscreenPreview() {
        const modal = new bootstrap.Modal(document.getElementById('billFullscreenModal'));
        modal.show();
    }
</script>
@endpush
