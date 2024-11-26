<?php
require '../db/config.php';

// Fetch users
$result = $conn->query("SELECT id, fname, lname, email, user_role, created_at FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../css/user_management.css">
</head>
<body>
    <h2>Manage Users</h2>

    <!-- Add User Form -->
    <form id="add-user-form">
        <h3>Add New User</h3>
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required>
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="1">Super Admin</option>
            <option value="2">Admin</option>
        </select>
        <button type="submit">Add User</button>
    </form>

    <!-- User List Table -->
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Registration Date</th>
            <th>Actions</th>
        </tr>
        <tbody id="user-list">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr id="user-<?php echo $row['id']; ?>">
                    <td><?php echo htmlspecialchars($row['fname'] . " " . $row['lname']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo $row['user_role'] == 1 ? "Super Admin" : "Admin"; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <button onclick="editUser(<?php echo $row['id']; ?>)">Edit</button>
                        <button onclick="deleteUser(<?php echo $row['id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

