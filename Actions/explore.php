<?php
include '../db/config.php';

$result = $conn->query("SELECT * FROM listings WHERE status = 'approved'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Explore - CasaConnect</title>
    <link rel="stylesheet" href="../css/explore.css">
</head>
<body>
    <h1>Property Listings</h1>
    <div class="grid">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="grid-item">
                <img src="<?php echo explode(',', $row['images'])[0]; ?>" alt="Property Image">
                <h3><?php echo htmlspecialchars($row['property_name']); ?></h3>
                <p>Location: <?php echo htmlspecialchars($row['location']); ?></p>
                <p>Price: $<?php echo number_format($row['price'], 2); ?></p>
                <a href="property.php?id=<?php echo $row['id']; ?>">View Details</a>
            </div>
        <?php } ?>
    </div>
</body>
</html>
