<?php
require '../db/config.php';

// Start session and validate admin
session_start();
if ($_SESSION['user_role'] !== 1) {
    header('Location: ../index.php');
    exit();
}

// Fetch booked consultations
$consultations = $conn->query("
    SELECT bc.id, u.fname, u.lname, cs.date, cs.time
    FROM booked_consultations bc
    JOIN users u ON bc.user_id = u.id
    JOIN consultation_slots cs ON bc.slot_id = cs.id
");

// Fetch booked property valuations
$valuations = $conn->query("
    SELECT bpv.id, u.fname, u.lname, pvs.date, pvs.time
    FROM booked_property_valuations bpv
    JOIN users u ON bpv.user_id = u.id
    JOIN property_valuation_slots pvs ON bpv.slot_id = pvs.id
");

// Handle deletion of bookings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = (int)$_POST['booking_id'];
    $booking_type = $_POST['booking_type'];

    if ($booking_type === 'consultation') {
        $stmt = $conn->prepare("DELETE FROM booked_consultations WHERE id = ?");
    } elseif ($booking_type === 'valuation') {
        $stmt = $conn->prepare("DELETE FROM booked_property_valuations WHERE id = ?");
    } else {
        die("Invalid booking type.");
    }

    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        echo "<p>Booking removed successfully.</p>";
    } else {
        echo "<p>Error removing booking: " . $conn->error . "</p>";
    }

    $stmt->close();
    header("Location: admin_manage_services.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Booked Services</title>
    <link rel="stylesheet" href="../css/admin_management_services.css">
</head>
<body>
    <header>
    <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <ul class="nav-links">
                <li><a href="./dashboard.php">Back</a></li>
            </ul>
        </nav>
    </header>
    <h1>Manage Booked Services</h1>

    <h2>Booked Consultations</h2>
    <table border="1">
        <tr>
            <th>Client Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $consultations->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['time']); ?></td>
                <td>
                    <form method="POST" action="admin_manage_services.php" style="display:inline;">
                        <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="booking_type" value="consultation">
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h2>Booked Property Valuations</h2>
    <table border="1">
        <tr>
            <th>Client Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $valuations->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['time']); ?></td>
                <td>
                    <form method="POST" action="admin_manage_services.php" style="display:inline;">
                        <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="booking_type" value="valuation">
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
