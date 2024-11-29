<?php
include '../db/config.php';
include '../functions/consultation_func.php';

// Fetch available consultation slots
$slots = getAvailableConsultationSlots($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewsport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Booking</title>
    <link rel="stylesheet" href="../css/consultation.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">CasaConnect</div>
            <ul class="nav-links">
                <li><a href="services.php">Back to Services</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Book a Consultation</h1>
        <div id="available-slots">
            <h2>Available Slots</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($slots) > 0): ?>
                        <?php foreach ($slots as $slot): ?>
                            <tr>
                                <td><?= htmlspecialchars($slot['date']) ?></td>
                                <td><?= htmlspecialchars($slot['time']) ?></td>
                                <td>
                                    <?php if ($slot['status'] === 'available'): ?>
                                        <form method="POST" action="../actions/book_slot.php">
                                            <input type="hidden" name="slot_id" value="<?= $slot['id'] ?>">
                                            <input type="hidden" name="table" value="consultation_slots">
                                            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>"> <!-- Dynamic user ID -->
                                            <button type="submit" class="book-btn">Book</button>
                                        </form>
                                    <?php elseif ($slot['status'] === 'booked'): ?>
                                        <form method="POST" action="../actions/cancel_slot.php">
                                            <input type="hidden" name="slot_id" value="<?= $slot['id'] ?>">
                                            <input type="hidden" name="table" value="consultation_slots">
                                            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>"> <!-- Dynamic user ID -->
                                            <button type="submit" class="cancel-btn">Cancel</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No consultation slots available at the moment. Please check back later.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
