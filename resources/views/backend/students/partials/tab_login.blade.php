<div class="tab-pane fade" id="login-tab" role="tabpanel">
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="text" id="password" name="password" class="form-control"
            value="{{ old('password', $student->password ?? '') }}">
        <div class="form-text">Leave blank to keep unchanged.</div>
    </div>

    <div class="mb-3">
        <label for="last_login" class="form-label">Last Login</label>
        <input type="datetime-local" id="last_login" name="last_login" class="form-control"
            value="{{ old('last_login', isset($student->last_login) ? \Carbon\Carbon::parse($student->last_login)->format('Y-m-d\TH:i') : '') }}">
    </div>

    <div class="mb-3">
        <label for="remark" class="form-label">Remark</label>
        <textarea name="remark" id="remark" rows="3" class="form-control">{{ old('remark', $student->remark ?? '') }}</textarea>
    </div>
</div>
