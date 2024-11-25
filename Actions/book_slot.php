<?php
include '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slot_id = $_POST['slot_id'];
    $user_id = $_POST['user_id']; // Replace with session user ID if logged in
    $table = $_POST['table'];      // Table name: 'property_valuation_slots' or 'consultation_slots'

    // Validate input
    if (!in_array($table, ['property_valuation_slots', 'consultation_slots'])) {
        echo "Error: Invalid table name.";
        exit;
    }

    // Check if the slot is available
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
        echo "Error: Slot already booked.";
        exit;
    }

    // Book the slot based on type
    $result = "";
    if ($type === 'consultation') {
        $result = bookConsultationSlot($conn, $slot_id, $user_id);
    } elseif ($type === 'valuation') {
        $result = bookValuationSlot($conn, $slot_id, $user_id);
    }

    $stmt->close();
    $conn->close();
}
?>