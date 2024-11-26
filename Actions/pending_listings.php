<?php
include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $listing_id = (int)$_POST['id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE listings SET status = 'approved' WHERE id = ?");
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("DELETE FROM listings WHERE id = ?");
    }

    $stmt->bind_param("i", $listing_id);
    if ($stmt->execute()) {
        echo "Listing updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Fetch pending listings
$result = $conn->query("SELECT * FROM listings WHERE status = 'pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pending Listings</title>
</head>
<body>
    <h2>Pending Listings</h2>
    <table border="1">
        <tr>
            <th>Property Name</th>
            <th>Location</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['property_name']); ?></td>
                <td><?php echo htmlspecialchars($row['location']); ?></td>
                <td><?php echo "$" . number_format($row['price'], 2); ?></td>
                <td>
                    <form method="post" action="pending_listings.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="action" value="approve">Approve</button>
                    </form>
                    <form method="post" action="pending_listings.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="action" value="reject">Reject</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
