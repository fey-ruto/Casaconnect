<?php
require '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $table = $_POST['table']; // Table name: 'consultation_slots' or 'property_valuation_slots'

    // Validate input
    if (!in_array($table, ['consultation_slots', 'property_valuation_slots'])) {
        echo "Error: Invalid table name";
        exit;
    }

    // Insert slot into the specified table
    $stmt = $conn->prepare("INSERT INTO $table (date, time) VALUES (?, ?)");
    if (!$stmt) {
        echo "Error: Invalid query or database error";
        exit;
    }

    $stmt->bind_param("ss", $date, $time);

    if ($stmt->execute()) {
        echo "Slot created successfully!";

        // Log the action (optional)
        $log_action = "Created a slot in $table on $date at $time";
        $admin_id = 1; // Replace with the actual admin ID from the session or authentication system
        $log_stmt = $conn->prepare("INSERT INTO logs (admin_id, action, timestamp) VALUES (?, ?, NOW())");

        if ($log_stmt) {
            $log_stmt->bind_param("is", $admin_id, $log_action);
            if ($log_stmt->execute()) {
                echo " Log entry created successfully.";
            } else {
                echo " Error logging the action: " . $log_stmt->error;
            }
            $log_stmt->close();
        } else {
            echo "Error preparing log entry statement.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
