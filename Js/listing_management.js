document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.edit-btn');
    const deleteButtons = document.querySelectorAll('.delete-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            const row = e.target.closest('tr');
            const listingId = row.getAttribute('data-id');

            // You can now proceed to edit the listing by opening a modal or redirecting to an edit page.
            // For simplicity, we will log the id here.
            console.log(`Editing listing with ID: ${listingId}`);

            // Send an AJAX request for the edit (you would expand this part to fetch listing details).
            const response = await fetch('../actions/listing_operations.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'update', id: listingId }),
            });

            const result = await response.json();
            if (result.success) {
                alert('Listing updated successfully!');
            } else {
                alert('Error updating the listing.');
            }
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            const row = e.target.closest('tr');
            const listingId = row.getAttribute('data-id');

            const response = await fetch('../actions/listing_operations.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'delete', id: listingId }),
            });

            const result = await response.json();
            if (result.success) {
                row.remove(); // Remove the listing from the table if delete is successful
            } else {
                alert('Error deleting the listing.');
            }
        });
    });
});