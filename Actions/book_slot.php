<?php
include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slot_id = $_POST['slot_id'];
    $user_id = $_POST['user_id']; // Replace with session user ID if logged in
    $table = $_POST['table'];     // Table name: 'property_valuation_slots' or 'consultation_slots'

    // Validate input
    if (!in_array($table, ['property_valuation_slots', 'consultation_slots'])) {
        echo "Error: Invalid table name.";
        exit;
    }

    // Check if the slot exists and is available
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

    // Mark the slot as booked
    $stmt = $conn->prepare("UPDATE $table SET status = 'booked', user_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $user_id, $slot_id);
    if ($stmt->execute()) {
        // Record the booking in the booked_slots table
        $type = ($table === 'consultation_slots') ? 'consultation' : 'valuation';
        $booking_stmt = $conn->prepare("INSERT INTO booked_slots (user_id, slot_id, type) VALUES (?, ?, ?)");
        $booking_stmt->bind_param("iis", $user_id, $slot_id, $type);

        if ($booking_stmt->execute()) {
            echo "Slot booked successfully and recorded in booked_slots!";
        } else {
            echo "Slot booked, but failed to record in booked_slots: " . $booking_stmt->error;
        }

        $booking_stmt->close();
    } else {
        echo "Error: Unable to book slot.";
    }

    $stmt->close();
    $conn->close();
}
?>
