<?php
include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $table = $_POST['table']; // 'consultation_slots' or 'property_valuation_slots'

    if (!in_array($table, ['consultation_slots', 'property_valuation_slots'])) {
        die("Invalid table.");
    }

    $stmt = $conn->prepare("INSERT INTO $table (date, time) VALUES (?, ?)");
    $stmt->bind_param("ss", $date, $time);
    if ($stmt->execute()) {
        echo "Slot created successfully!";
    } else {
        die("Error creating slot.");
    }
}
