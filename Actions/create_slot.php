<?php
require '../db/connect.php';

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

        // Log the action
        $log_action = "Created a $type slot on $date at $time";
        $admin_id = 1; // Replace with dynamic admin ID from session or authentication system
        $log_stmt = $conn->prepare("INSERT INTO logs (admin_id, action, timestamp) VALUES (?, ?, NOW())");
        $log_stmt->bind_param("is", $admin_id, $log_action);

        if ($log_stmt->execute()) {
            echo " Log entry created successfully.";
        } else {
            echo " Error logging the action: " . $log_stmt->error;
        }

        $log_stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
<<<<<<< HEAD
?>
=======
?>

>>>>>>> 1bdadd6238121faf71ab1ab987eadb9bce9d8607
