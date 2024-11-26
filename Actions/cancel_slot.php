<?php
include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slot_id = $_POST['slot_id'];
    $user_id = $_POST['user_id'];
    $table = $_POST['table'];

    // Validate input
    if (!in_array($table, ['property_valuation_slots', 'consultation_slots'])) {
        http_response_code(400); // Bad Request
        echo "Error: Invalid table name.";
        exit;
    }

    // Check if the slot exists and is booked by the current user
    $stmt = $conn->prepare("SELECT user_id, status FROM $table WHERE id = ?");
    if (!$stmt) {
        http_response_code(500); // Internal Server Error
        echo "Error: Failed to prepare the query.";
        exit;
    }
    $stmt->bind_param("i", $slot_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Error: Slot does not exist.";
        $stmt->close();
        $conn->close();
        exit;
    }

    $slot = $result->fetch_assoc();
    if ($slot['status'] !== 'booked' || $slot['user_id'] != $user_id) {
        echo "Error: You cannot cancel this slot.";
        $stmt->close();
        $conn->close();
        exit;
    }

    // Cancel the slot
    $stmt = $conn->prepare("UPDATE $table SET status = 'available', user_id = NULL WHERE id = ?");
    if (!$stmt) {
        http_response_code(500); // Internal Server Error
        echo "Error: Failed to prepare the cancel query.";
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $slot_id);

    if ($stmt->execute()) {
        echo "Slot canceled successfully!";
    } else {
        echo "Error: Unable to cancel slot.";
    }

    $stmt->close();
    $conn->close();
}
?>
