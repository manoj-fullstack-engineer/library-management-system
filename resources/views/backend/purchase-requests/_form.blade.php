<div class="row g-3">
    {{-- Item Name --}}
    <div class="col-md-6">
        <label class="form-label">📦 Item Name <span class="text-danger">*</span></label>
        <input type="text" name="item_name" value="{{ old('item_name', $requestData->item_name ?? '') }}"
            class="form-control shadow-sm @error('item_name') is-invalid @enderror" placeholder="Enter item name">
        @error('item_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Author --}}
    <div class="col-md-6">
        <label class="form-label">✍️ Author</label>
        <input type="text" name="author" value="{{ old('author', $requestData->author ?? '') }}"
            class="form-control shadow-sm @error('author') is-invalid @enderror" placeholder="Enter author name">
        @error('author')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Publisher --}}
    <div class="col-md-6">
        <label class="form-label">🏢 Publisher</label>
        <input type="text" name="publisher" value="{{ old('publisher', $requestData->publisher ?? '') }}"
            class="form-control shadow-sm @error('publisher') is-invalid @enderror" placeholder="Enter publisher">
        @error('publisher')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- ISBN --}}
    <div class="col-md-6">
        <label class="form-label">📘 ISBN</label>
        <input type="text" name="isbn" value="{{ old('isbn', $requestData->isbn ?? '') }}"
            class="form-control shadow-sm @error('isbn') is-invalid @enderror" placeholder="ISBN number">
        @error('isbn')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Inventory Category --}}
    <div class="col-md-6">
        <label class="form-label">🗂️ Category <span class="text-danger">*</span></label>
        <select name="inventory_category_id" class="form-select shadow-sm @error('inventory_category_id') is-invalid @enderror">
            <option value="">-- Select Category --</option>
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}" {{ old('inventory_category_id', $requestData->inventory_category_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        @error('inventory_category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Quantity --}}
    <div class="col-md-3">
        <label class="form-label">🔢 Quantity <span class="text-danger">*</span></label>
        <input type="number" name="quantity" value="{{ old('quantity', $requestData->quantity ?? '') }}"
            class="form-control shadow-sm @error('quantity') is-invalid @enderror" placeholder="e.g. 10">
        @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Estimated Cost --}}
    <div class="col-md-3">
        <label class="form-label">💰 Estimated Cost (₹)</label>
        <input type="number" step="0.01" name="estimated_cost"
            value="{{ old('estimated_cost', $requestData->estimated_cost ?? '') }}"
            class="form-control shadow-sm @error('estimated_cost') is-invalid @enderror" placeholder="e.g. 499.99">
        @error('estimated_cost')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Requested By --}}
    <div class="col-md-6">
        <label class="form-label">👤 Requested By</label>
        @if (empty($requestData))
            <input type="text" class="form-control shadow-sm" value="{{ Auth::user()->name }}" readonly>
            <input type="hidden" name="requested_by" value="{{ Auth::id() }}">
        @else
            <input type="text" class="form-control shadow-sm" value="{{ $requestData->creator->name ?? 'N/A' }}" readonly>
        @endif
    </div>

    {{-- Remark --}}
    <div class="col-md-12">
        <label class="form-label">📝 Remark</label>
        <textarea name="remark" rows="3"
            class="form-control shadow-sm @error('remark') is-invalid @enderror"
            placeholder="Additional notes or remarks">{{ old('remark', $requestData->remark ?? '') }}</textarea>
        @error('remark')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
