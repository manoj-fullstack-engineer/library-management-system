<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $enquiry->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $enquiry->email ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Phone</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $enquiry->phone ?? '') }}">
</div>

<div class="mb-3">
    <label>Message</label>
    <textarea name="message" class="form-control" required>{{ old('message', $enquiry->message ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control" required>
        @foreach(['New', 'In Progress', 'Resolved'] as $status)
            <option value="{{ $status }}" @if(old('status', $enquiry->status ?? '') == $status) selected @endif>
                {{ $status }}
            </option>
        @endforeach
    </select>
</div>
