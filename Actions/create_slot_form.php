<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Slot</title>
</head>
<body>
    <h1>Create a New Slot</h1>
    <form action="create_slot.php" method="POST">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required><br><br>

        <label for="table">Service Type:</label>
        <select id="table" name="table" required>
            <option value="consultation_slots">Consultation</option>
            <option value="property_valuation_slots">Property Valuation</option>
        </select><br><br>

        <button type="submit">Create Slot</button>
    </form>
</body>
</html>
