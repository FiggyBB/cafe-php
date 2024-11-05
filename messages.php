<?php
include 'db_connect.php';
session_start(); // Start the session

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.html');
    exit();
}

// Process delete request for a message
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM contacts WHERE id='$id'";
    if (mysql_query($sql, $conn)) {
        echo "Message deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysql_error($conn);
    }
}

$result = mysql_query("SELECT * FROM contacts", $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Contact Messages</h1>
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
            <h2>Messages List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysql_num_rows($result) > 0) {
                        while($row = mysql_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['message']}</td>
                                    <td>
                                        <a href='messages.php?delete_id={$row['id']}'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No messages found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
