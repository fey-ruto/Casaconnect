<?php
include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $slot_id = $_POST['slot_id'];
    $user_id = $_SESSION['user_id']; // Use session to fetch the logged-in user's ID
    $table = $_POST['table']; // Table name: 'consultation_slots' or 'property_valuation_slots'

    // Validate the table name
    if (!in_array($table, ['consultation_slots', 'property_valuation_slots'])) {
        die("Error: Invalid table name.");
    }

    // Check if the slot exists, is booked, and is booked by the current user
    $stmt = $conn->prepare("SELECT user_id, status FROM $table WHERE id = ?");
    $stmt->bind_param("i", $slot_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Error: Slot does not exist.");
    }

    $slot = $result->fetch_assoc();
    if ($slot['status'] !== 'booked') {
        die("Error: Slot is not booked.");
    }
    if ($slot['user_id'] != $user_id) {
        die("Error: You cannot cancel this slot.");
    }

    // Cancel the slot
    $stmt = $conn->prepare("UPDATE $table SET status = 'available', user_id = NULL WHERE id = ?");
    $stmt->bind_param("i", $slot_id);

    if ($stmt->execute()) {
        // Redirect to the corresponding frontend page
        header("Location: ../frontend/" . ($table === 'consultation_slots' ? 'consultation.php' : 'property_valuation.php') . "?status=success");
        exit;
    } else {
        // Error during update
        header("Location: ../frontend/" . ($table === 'consultation_slots' ? 'consultation.php' : 'property_valuation.php') . "?status=error");
        exit;
    }

    // Close the statement
    $stmt->close();
    $conn->close();
};
?>
