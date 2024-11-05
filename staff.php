<?php
include 'db_connect.php';
session_start(); // Start the session

// Correct authorization logic
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.html');
    exit();
}

/**
 * Process form submission for adding or updating staff members.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysql_real_escape_string($_POST['name']);
    $role = mysql_real_escape_string($_POST['role']);
    $email = mysql_real_escape_string($_POST['email']);
    $password = mysql_real_escape_string($_POST['password']); // Hash the password

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        // Update an existing staff member
        $id = $_POST['id'];
        $sql = "UPDATE users SET username='$name', email='$email', password='$password', user_type='staff' WHERE id='$id'";
        if (mysql_query($sql, $conn)) {
            echo "Staff member updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysql_error($conn);
        }
    } else {
        // Add a new staff member
        $sql = "INSERT INTO users (username, email, password, user_type) VALUES ('$name', '$email', '$password', 'staff')";
        if (mysql_query($sql, $conn)) {
            echo "New staff member added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysql_error($conn);
        }
    }
}

/**
 * Process delete request for a staff member.
 */
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM users WHERE id='$id' AND user_type='staff'";
    if (mysql_query($sql, $conn)) {
        echo "Staff member deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysql_error($conn);
    }
}

$result = mysql_query("SELECT * FROM users WHERE user_type='staff'", $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Staff - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Staff</h1>
    </header>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="preorders.php">Preorders</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="staff.php">Staff</a></li>
            <li><a href="customers.php">Customers</a></li>
            <li><a href="index.html">Website</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <div class="container">
            <h2>Staff List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysql_num_rows($result) > 0) {
                        while($row = mysql_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['email']}</td>
                                    <td>
                                        <a href='staff.php?edit_id={$row['id']}'>Edit</a> |
                                        <a href='staff.php?delete_id={$row['id']}'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No staff found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <h2><?php echo isset($_GET['edit_id']) ? 'Edit' : 'Add'; ?> Staff Member</h2>
            <form action="staff.php" method="post">
                <?php
                if (isset($_GET['edit_id'])) {
                    $edit_id = $_GET['edit_id'];
                    $edit_result = mysql_query("SELECT * FROM users WHERE id='$edit_id' AND user_type='staff'", $conn);
                    $edit_row = mysql_fetch_assoc($edit_result);
                    echo "<input type='hidden' name='id' value='{$edit_row['id']}'>";
                }
                ?>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($edit_row['username']) ? $edit_row['username'] : ''; ?>" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($edit_row['email']) ? $edit_row['email'] : ''; ?>" required>
                <label for="role">Role:</label>
                <input type="text" id="role" name="role" value="<?php echo isset($edit_row['role']) ? $edit_row['role'] : ''; ?>" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit"><?php echo isset($_GET['edit_id']) ? 'Update' : 'Add'; ?> Staff Member</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 The Gallery Café</p>
    </footer>
</body>
</html>

<?php
mysql_close($conn);
?>
