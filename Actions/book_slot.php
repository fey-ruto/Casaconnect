<?php
include '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slot_id = $_POST['slot_id'];   // Slot ID to book
    $user_id = $_POST['user_id'];  // User ID (from session or passed directly)
    $table = $_POST['table'];      // Table name: 'consultation_slots' or 'property_valuation_slots'

    // Validate input
    if (!in_array($table, ['consultation_slots', 'property_valuation_slots'])) {
        echo "Error: Invalid table name.";
        exit;
    }

    // Check if the slot is still available
    $stmt = $conn->prepare("SELECT status FROM $table WHERE id = ?");
    $stmt->bind_param("i", $slot_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Error: Slot does not exist.";
        exit;
    }

    $slot = $result->fetch_assoc();
    if ($slot['status'] !== 'available') {
        echo "Error: Slot is already booked.";
        exit;
    }

    // Book the slot by updating the status and linking it to the user
    $stmt = $conn->prepare("UPDATE $table SET status = 'booked', user_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $user_id, $slot_id);

    if ($stmt->execute()) {
        echo "Slot booked successfully!";
    } else {
        echo "Error: Unable to book slot.";
    }

    $stmt->close();
    $conn->close();
}
?>

