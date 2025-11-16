document.addEventListener('DOMContentLoaded', function() {
    const deleteModalElement = document.getElementById('confirmUserDeletionModal');
    
    if (deleteModalElement && deleteModalElement.dataset.hasErrors === 'true') {
        if (typeof bootstrap !== 'undefined') {
            const deleteModal = new bootstrap.Modal(deleteModalElement);
            deleteModal.show();
        } else {
            console.error('Bootstrap not loaded!');
        }
    }
});