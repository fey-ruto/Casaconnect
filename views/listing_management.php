<?php
include "../actions/listing_management.php";
include "../actions/listing_operations.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewsport" content="width=device-width, initial-scale=1.0">
    <title>Listing Management - CasaConnect</title>
    <link rel="stylesheet" href="../css/listing_management.css">
</head>
<body>
    <header>
    <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <ul class="nav-links">
                <li><a href="../actions/dashboard.php">Back</a></li>
            </ul>
        </nav>
    </header>
    <h1>Listings</h1>
    <div id="estate-list">
        <?php if (empty($listings)): ?>
            <p>No listings available.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Property Name</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listings as $listing): ?>
                        <tr data-id="<?= $listing['id'] ?>">
                            <td><?= htmlspecialchars($listing['property_name']) ?></td>
                            <td><?= htmlspecialchars($listing['location']) ?></td>
                            <td>$<?= number_format($listing['price'], 2) ?></td>
                            <td><?= htmlspecialchars($listing['status']) ?></td>
                            <td>
                                <button class="edit-btn">Edit</button>
                                <button class="delete-btn">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <script src="../js/listing_management.js"></script>
</body>
</html>
