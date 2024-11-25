<?php
include '../db/connect.php';

$table = $_GET['table']; // Get the table name from the query parameters

// Validate table input
if (!in_array($table, ['property_valuation_slots', 'consultation_slots'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid table name']);
    exit;
}

// Fetch available and booked slots from the specified table
$stmt = $conn->prepare("SELECT id, date, time, status FROM $table WHERE status IN ('available', 'booked')");
$stmt->execute();
$result = $stmt->get_result();
$slots = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($slots);

$stmt->close();
$conn->close();
?>


