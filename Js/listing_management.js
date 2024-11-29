document.addEventListener('DOMContentLoaded', () => {
    // Event listeners for edit and delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const editButtons = document.querySelectorAll('.edit-btn');

    // Delete Listing
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const listingId = e.target.closest('tr').dataset.id;
            if (confirm('Are you sure you want to delete this listing?')) {
                fetch('listing_operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ action: 'delete', id: listingId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        e.target.closest('tr').remove();
                    } else {
                        alert('Failed to delete listing.');
                    }
                });
            }
        });
    });

    // Edit Listing (you can extend this to show an edit form/modal)
    editButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const listingId = e.target.closest('tr').dataset.id;
            window.location.href = `edit_listing.php?id=${listingId}`;
        });
    });
});
