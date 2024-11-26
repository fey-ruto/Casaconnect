<?php
include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slot_id = $_POST['slot_id'];
    $user_id = $_POST['user_id']; // Replace with session user ID
    $table = $_POST['table'];

    if (!in_array($table, ['consultation_slots', 'property_valuation_slots'])) {
        die("Invalid table.");
    }

    $stmt = $conn->prepare("SELECT status FROM $table WHERE id = ?");
    $stmt->bind_param("i", $slot_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0 || $result->fetch_assoc()['status'] !== 'available') {
        die("Slot not available.");
    }

    $stmt = $conn->prepare("UPDATE $table SET status = 'booked', user_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $user_id, $slot_id);
    if ($stmt->execute()) {
        header("Location: ../frontend/" . ($table === 'consultation_slots' ? 'consultation.php' : 'property_valuation.php'));
        exit;
    } else {
        die("Error booking slot.");
    }
}
