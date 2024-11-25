<?php
include '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $table = $_POST['table']; // Name of the table: 'consultation_slots' or 'property_valuation_slots'

    // Validate input
    if (!in_array($table, ['consultation_slots', 'property_valuation_slots'])) {
        echo "Error: Invalid table name";
        exit;
    }

    // Insert slot into the respective table
    $stmt = $conn->prepare("INSERT INTO $table (date, time, status) VALUES (?, ?, 'available')");
    $stmt->bind_param("ss", $date, $time);

    if ($stmt->execute()) {
        echo "Slot created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

