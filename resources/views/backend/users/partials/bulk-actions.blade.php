<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="bulkDeleteModalLabel">
          <i class="fas fa-exclamation-triangle me-2"></i>Confirm Bulk Deletion
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>You are about to delete <strong><span id="selectedCount">0</span> users</strong>. This action cannot be undone.</p>
        <div class="alert alert-warning mt-3">
          <i class="fas fa-info-circle me-2"></i>All related data will also be permanently removed.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-2"></i>Cancel
        </button>
        <form id="bulkDeleteForm" method="POST" action="{{ route('backend.users.bulk.delete') }}">
          @csrf
          @method('DELETE')
          <input type="hidden" name="selected_ids" id="selectedIdsInput">
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash-alt me-2"></i>Confirm Delete
          </button>
        </form>
      </div>
    </div>
  </div>
</div>