<?php
include '../db/connect.php';

// Get the table parameter from the query string
$table = $_GET['table']; // consultation_slots or property_valuation_slots

// Validate input
if (!in_array($table, ['consultation_slots', 'property_valuation_slots'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid table name']);
    exit;
}

// Fetch available slots from the specified table
$stmt = $conn->prepare("SELECT id, date, time FROM $table WHERE status = 'available'");
$stmt->execute();
$result = $stmt->get_result();
$slots = $result->fetch_all(MYSQLI_ASSOC);

// Return the slots as JSON
header('Content-Type: application/json');
echo json_encode($slots);

$stmt->close();
$conn->close();
?>

