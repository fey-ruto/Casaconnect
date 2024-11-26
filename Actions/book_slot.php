<?php
include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $slot_id = $_POST['slot_id'];
    $user_id = $_SESSION['user_id']; // Use session user ID
    $table = $_POST['table']; // Table name: 'property_valuation_slots' or 'consultation_slots'

    // Validate input
    if (!in_array($table, ['property_valuation_slots', 'consultation_slots'])) {
        echo "Error: Invalid table name.";
        exit;
    }

    // Start transaction
    $conn->begin_transaction();
    try {
        // Check if the slot exists and is available
        $stmt = $conn->prepare("SELECT status FROM $table WHERE id = ?");
        $stmt->bind_param("i", $slot_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Slot does not exist.");
        }

        $slot = $result->fetch_assoc();
        if ($slot['status'] !== 'available') {
            throw new Exception("Slot already booked.");
        }

        // Mark the slot as booked
        $stmt = $conn->prepare("UPDATE $table SET status = 'booked', user_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $user_id, $slot_id);
        if (!$stmt->execute()) {
            throw new Exception("Error updating slot status: " . $stmt->error);
        }

        // Record the booking in the booked_slots table
        $type = ($table === 'consultation_slots') ? 'consultation' : 'valuation';
        $booking_stmt = $conn->prepare("INSERT INTO booked_slots (user_id, slot_id, type) VALUES (?, ?, ?)");
        $booking_stmt->bind_param("iis", $user_id, $slot_id, $type);
        if (!$booking_stmt->execute()) {
            throw new Exception("Failed to record in booked_slots: " . $booking_stmt->error);
        }

        // Commit transaction
        $conn->commit();
        echo "Slot booked successfully and recorded in booked_slots!";
    } catch (Exception $e) {
        // Rollback transaction
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Close statements and connection
    $stmt->close();
    $booking_stmt->close();
    $conn->close();
}
?>
