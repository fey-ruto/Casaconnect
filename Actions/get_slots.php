<?php
// Include database connection
include '../db/config.php';

$type = $_GET['type']; // Get the slot type from query parameters

// Validate input
if (!in_array($type, ['consultation', 'valuation'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid slot type']);
    exit;
}

// Determine the table to query based on the type
$table = ($type === 'consultation') ? 'consultation_slots' : 'property_valuation_slots';

// Query to fetch slots
$stmt = $conn->prepare("SELECT id, date, time, status FROM $table WHERE status IN ('available', 'booked')");
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    $slots = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database query failed']);
    $conn->close();
    exit;
}

// Return slots as JSON
header('Content-Type: application/json');
echo json_encode($slots);

// Close the database connection
$conn->close();
?>
