<?php
require '../db/config.php';

// Start session and validate admin
session_start();
if ($_SESSION['user_role'] !== 1) {
    header('Location: ../index.php');
    exit();
}

// Handle approval or rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $listing_id = (int)$_POST['id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE listings SET status = 'approved' WHERE id = ?");
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("DELETE FROM listings WHERE id = ?");
    } else {
        die('Invalid action.');
    }

    $stmt->bind_param("i", $listing_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}

// Fetch pending listings
$result = $conn->query("SELECT id, property_name, SUBSTRING(description, 1, 30) AS short_description, price, images FROM listings WHERE status = 'pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pending Listings</title>
    <link rel="stylesheet" href="../css/pending_listings.css">
</head>
<body>
    <h1>Pending Listings</h1>
    <div class="listings-grid">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="listing-item">
                <img src="<?php echo htmlspecialchars(explode(',', $row['images'])[0]); ?>" alt="Property Image">
                <h3><?php echo htmlspecialchars($row['property_name']); ?></h3>
                <p>Description: <?php echo htmlspecialchars($row['short_description']); ?>...</p>
                <p>Price: $<?php echo number_format($row['price'], 2); ?></p>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="action" value="approve">Approve</button>
                </form>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="action" value="reject">Reject</button>
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>
