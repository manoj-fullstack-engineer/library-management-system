document.addEventListener('DOMContentLoaded', function() {
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const checkboxes = document.querySelectorAll('.select-item');
    const selectedCount = document.getElementById('selectedCount');
    const selectedIdsInput = document.getElementById('selectedIdsInput');
    
    // Enable/disable bulk delete button
    function updateBulkDeleteBtn() {
        const checked = document.querySelectorAll('.select-item:checked');
        bulkDeleteBtn.disabled = checked.length === 0;
        
        // Update selected count in modal
        if (selectedCount) {
            selectedCount.textContent = checked.length;
        }
    }
    
    // Attach event listeners
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkDeleteBtn);
    });
    
    // Before modal shows
    document.getElementById('bulkDeleteModal').addEventListener('show.bs.modal', function() {
        const selectedIds = Array.from(document.querySelectorAll('.select-item:checked'))
                               .map(checkbox => checkbox.value);
        selectedIdsInput.value = JSON.stringify(selectedIds);
    });
    
    // Select all checkbox
    document.getElementById('selectAll')?.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkDeleteBtn();
    });
});