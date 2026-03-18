@csrf

<div class="card shadow-sm">
  <div class="card-body">
    <div class="row g-3">

      {{-- Category Name --}}
      <div class="col-md-6">
        <div class="form-floating position-relative">
          <input 
              type="text" 
              name="name" 
              id="name" 
              class="form-control @error('name') is-invalid @enderror" 
              value="{{ old('name', $inventoryCategory->name ?? '') }}" 
              placeholder="Category Name"
              required
          >
          <label for="name"><i class="bi bi-tag me-1"></i> Category Name</label>
          @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- Status --}}
      <div class="col-md-6">
        <div class="form-floating">
          <select 
              name="status" 
              id="status" 
              class="form-select @error('status') is-invalid @enderror"
          >
            <option value="1" {{ old('status', $inventoryCategory->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $inventoryCategory->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
          </select>
          <label for="status"><i class="bi bi-toggle-on me-1"></i> Status</label>
          @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- Description (floating effect using textarea wrapper) --}}
      <div class="col-12">
        <div class="form-floating">
          <textarea 
              name="description" 
              id="description" 
              class="form-control @error('description') is-invalid @enderror" 
              placeholder="Write a short description..."
              style="height: 120px"
          >{{ old('description', $inventoryCategory->description ?? '') }}</textarea>
          <label for="description"><i class="bi bi-chat-left-text me-1"></i> Description</label>
          @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

    </div>
  </div>
</div>
