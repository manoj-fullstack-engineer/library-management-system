<div class="tab-pane fade show active" id="basic-info" role="tabpanel">
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
            <input type="text" name="first_name" id="first_name" class="form-control"
                   value="{{ old('first_name', $student->first_name ?? '') }}" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" class="form-control"
                   value="{{ old('middle_name', $student->middle_name ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" name="last_name" id="last_name" class="form-control"
                   value="{{ old('last_name', $student->last_name ?? '') }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email', $student->email ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="contact_number" class="form-label">Contact No.</label>
            <input type="text" name="contact_number" id="contact_number" class="form-control"
                   value="{{ old('contact_number', $student->contact_number ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                   value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" id="gender" class="form-select">
                <option value="">-- Select --</option>
                <option value="male" {{ old('gender', $student->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $student->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', $student->gender ?? '') === 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div class="col-md-8 mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" rows="2" class="form-control">{{ old('address', $student->address ?? '') }}</textarea>
        </div>
    </div>
</div>
