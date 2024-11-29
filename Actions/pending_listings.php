<?php
require '../db/config.php';

// Start session and validate admin
session_start();
if ($_SESSION['user_role'] !== 1) {
    echo 'Unauthorized access.'; // Normal message for page load
    exit();
}

// Handle approval or rejection via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    $listing_id = (int)$_POST['id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE listings SET status = 'approved' WHERE id = ?");
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("DELETE FROM listings WHERE id = ?");
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
        exit();
    }

    $stmt->bind_param("i", $listing_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => ucfirst($action) . 'd successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}

// Fetch pending listings
$result = $conn->query("SELECT id, property_name, SUBSTRING(description, 1, 30) AS short_description, price, images FROM listings WHERE status = 'pending'");

$listings = [];
while ($row = $result->fetch_assoc()) {
    $listings[] = $row;
}

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    // Return JSON response if it's an AJAX request
    echo json_encode(['status' => 'success', 'listings' => $listings]);
} else {
// Otherwise, render the HTML page normally
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewsport" content="width=device-width, initial-scale=1.0">
        <title>Pending Listings - CasaConnect</title>
        <link rel="stylesheet" href="../css/pending_listings.css">
    </head>
    <body>
        <h1>Pending Listings</h1>
        <div class="listings-grid" id="listingsGrid">
            <?php if (count($listings) > 0) : ?>
                <?php foreach ($listings as $row) : ?>
                    <div class="listing-item">
                        <img src="<?php echo htmlspecialchars(explode(',', $row['images'])[0]); ?>" alt="Property Image">
                        <h3><?php echo htmlspecialchars($row['property_name']); ?></h3>
                        <p>Description: <?php echo htmlspecialchars($row['short_description']); ?>...</p>
                        <p>Price: $<?php echo number_format($row['price'], 2); ?></p>
                        <button class="approve-btn" data-id="<?php echo $row['id']; ?>">Approve</button>
                        <button class="reject-btn" data-id="<?php echo $row['id']; ?>">Reject</button>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No pending listings found.</p>
            <?php endif; ?>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Approve and reject buttons event listeners
                const approveButtons = document.querySelectorAll('.approve-btn');
                const rejectButtons = document.querySelectorAll('.reject-btn');

                approveButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        handleAction(event, 'approve');
                    });
                });

                rejectButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        handleAction(event, 'reject');
                    });
                });

                // Handle action (approve or reject) via AJAX
                function handleAction(event, action) {
                    const listingId = event.target.getAttribute('data-id');
                    const formData = new FormData();
                    formData.append('id', listingId);
                    formData.append('action', action);

                    fetch('pending_listings.php', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // AJAX request header
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert(data.message); // Show success message
                            removeListing(listingId); // Remove the listing from the grid
                        } else {
                            alert('Error: ' + data.message); // Show error message
                        }
                    })
                    .catch(error => {
                        alert('An error occurred: ' + error.message);
                    });
                }

                // Remove listing item from the grid
                function removeListing(id) {
                    const listingItem = document.querySelector(`[data-id="${id}"]`).closest('.listing-item');
                    listingItem.remove();
                }
            });
        </script>
    </body>
    </html>
    <?php
}
?>