<?php
require '../db/config.php';

// Receive the incoming request as JSON
$data = json_decode(file_get_contents('php://input'), true);

if ($data['action'] == 'delete') {
    // Sanitize and validate the ID
    $id = isset($data['id']) ? (int)$data['id'] : 0;
    if ($id > 0) {
        // Delete the listing from the database
        $stmt = $conn->prepare("DELETE FROM listings WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
} elseif ($data['action'] == 'update') {
    // Handle updates (e.g., change status or price)
    // Add necessary code for updating listings
}
?>
