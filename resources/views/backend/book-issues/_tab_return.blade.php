<div class="tab-pane fade" id="tab-return" role="tabpanel">
    <div class="row g-4">

        {{-- Book ID with Preview --}}
        <div class="col-md-6">
            <label for="book_id_return" class="form-label fw-semibold">📚 Book ID (numeric)</label>
            <div class="input-group shadow-sm">
                <input type="number" id="book_id_return" name="book_id_return" class="form-control"
                    value="{{ old('book_id', $bookIssue->book_id ?? '') }}" placeholder="Enter numeric Book ID"
                    autofocus>
                <button type="button" class="btn btn-outline-primary" onclick="previewIssuedBook()"
                    title="Preview Book">🔍</button>
            </div>
        </div>

        {{-- Issued At --}}
        @if (isset($bookIssue))
            <div class="col-md-6">
                <label class="form-label fw-semibold">🕒 Issued At</label>
                <input type="text" class="form-control shadow-sm"
                    value="{{ $bookIssue->issued_at?->format('d/m/Y H:i') }}" readonly>
            </div>
        @endif

        {{-- Returned At or Return Date --}}
        @if (isset($bookIssue->returned_at))
            <div class="col-md-6">
                <label class="form-label fw-semibold">🔄 Returned At</label>
                <input type="text" class="form-control shadow-sm"
                    value="{{ $bookIssue->returned_at?->format('d/m/Y H:i') }}" readonly>
            </div>
        @else
            <div class="col-md-6">
                <label for="return_date" class="form-label fw-semibold">🔙 Return Date</label>
                <input type="datetime-local" name="return_date" id="return_date" class="form-control shadow-sm"
                    value="{{ old('return_date', now()->format('Y-m-d\TH:i')) }}">
            </div>
        @endif

        {{-- Book Condition --}}
        <div class="col-md-6">
            <label for="book_condition" class="form-label fw-semibold">📦 Book Condition</label>
            <select name="book_condition" id="book_condition" class="form-select shadow-sm" required>
                <option value="">-- Select Condition --</option>
                <option value="Good"
                    {{ old('book_condition', $bookIssue->book_condition ?? '') == 'Good' ? 'selected' : '' }}>Good
                </option>
                <option value="Damaged"
                    {{ old('book_condition', $bookIssue->book_condition ?? '') == 'Damaged' ? 'selected' : '' }}>Damaged
                </option>
                <option value="Lost"
                    {{ old('book_condition', $bookIssue->book_condition ?? '') == 'Lost' ? 'selected' : '' }}>Lost
                </option>
            </select>
        </div>

        {{-- Fine Amount --}}
        <div class="col-md-6">
            <label for="fine_amount" class="form-label fw-semibold">💰 Fine Amount (₹)</label>
            <input type="number" step="0.01" min="0" name="fine_amount" id="fine_amount"
                class="form-control shadow-sm" value="{{ old('fine_amount', $bookIssue->fine_amount ?? '') }}"
                placeholder="Enter fine if applicable">
        </div>

        {{-- Return Remark --}}
        <div class="col-md-12">
            <label for="return_remark" class="form-label fw-semibold">📝 Return Remark</label>
            <textarea name="return_remark" id="return_remark" class="form-control shadow-sm" rows="3"
                placeholder="Write return note...">{{ old('return_remark', $bookIssue->return_remark ?? '') }}</textarea>
        </div>

        {{-- Overdue Badge --}}
        @if ($bookIssue?->is_overdue)
            <div class="col-md-6 d-flex align-items-end">
                <span class="badge bg-danger fs-6">⚠️ Overdue</span>
            </div>
        @endif

        {{-- Save and Exit --}}
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-success me-2">💾 Save</button>
            <a href="{{ route('backend.book-issues.index') }}" class="btn btn-secondary">✖ Exit</a>
        </div>
    </div>
</div>

{{-- 📘 Book Preview Modal --}}
@push('modals')
    <div class="modal fade" id="bookIssuePreviewModal" tabindex="-1" aria-labelledby="bookIssuePreviewTitle"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="bookIssuePreviewTitle">📘 Book Issue Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="bookIssuePreviewBody">
                    <div class="text-center text-muted">Loading...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">✖ Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush


@push('scripts')
    <script>
        function previewIssuedBook() {
            const input = document.getElementById('book_id_return');
            const rawValue = input?.value?.trim() || '';
            const bookId = parseInt(rawValue, 10);

            const modalEl = document.getElementById('bookIssuePreviewModal');
            const modal = new bootstrap.Modal(modalEl);
            const previewBody = document.getElementById('bookIssuePreviewBody');
            const previewTitle = document.getElementById('bookIssuePreviewTitle');

            if (!bookId || isNaN(bookId) || bookId <= 0) {
                Swal.fire('Missing ID', 'Please enter a valid numeric Book ID.', 'warning');
                return;
            }

            previewTitle.innerHTML = '📘 Fetching...';
            previewBody.innerHTML = `<div class="text-center text-muted">⏳ Loading issue details...</div>`;
            modal.show();

            fetch(`/backend/book-issues/preview-by-book/${bookId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Response not OK');
                    return res.json();
                })
                .then(data => {
                    if (data.status === 'error') {
                        previewTitle.innerHTML = '❌ Not Issued';
                        previewBody.innerHTML = `<div class="text-danger">${data.message}</div>`;
                    } else {
                        previewTitle.innerHTML = `📘 Issued To: ${data.student_name || 'Unknown'}`;
                        previewBody.innerHTML = data.html;
                    }
                })
                .catch(error => {
                    console.error('Fetch failed:', error);
                    previewTitle.innerHTML = '⚠️ Error';
                    previewBody.innerHTML = `<div class="text-danger">❌ Failed to load issue information.</div>`;
                });

            // Reset modal content when hidden
            modalEl.addEventListener('hidden.bs.modal', function() {
                previewTitle.innerHTML = '📘 Book Issue Info';
                previewBody.innerHTML = '';
            }, {
                once: true
            });
        }
    </script>
@endpush
