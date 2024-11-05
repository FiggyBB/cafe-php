<?php
include 'db_connect.php';
session_start(); // Start the session

// Correct authorization logic
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.html');
    exit();
}

/**
 * Process form submission for adding or updating customers.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysql_real_escape_string($_POST['name']);
    $email = mysql_real_escape_string($_POST['email']);
    $password = mysql_real_escape_string($_POST['password']); // Assume no hashing for now

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        // Update an existing customer
        $id = $_POST['id'];
        $sql = "UPDATE users SET username='$name', email='$email', password='$password', user_type='customer' WHERE id='$id'";
        if (mysql_query($sql, $conn)) {
            echo "Customer updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysql_error($conn);
        }
    } else {
        // Add a new customer
        $sql = "INSERT INTO users (username, email, password, user_type) VALUES ('$name', '$email', '$password', 'customer')";
        if (mysql_query($sql, $conn)) {
            echo "New customer added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysql_error($conn);
        }
    }
}

/**
 * Process delete request for a customer.
 */
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM users WHERE id='$id' AND user_type='customer'";
    if (mysql_query($sql, $conn)) {
        echo "Customer deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysql_error($conn);
    }
}

$result = mysql_query("SELECT * FROM users WHERE user_type='customer'", $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Customers - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Customers</h1>
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
            <h2>Customer List</h2>
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
                                        <a href='customers.php?edit_id={$row['id']}'>Edit</a> |
                                        <a href='customers.php?delete_id={$row['id']}'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No customers found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <h2><?php echo isset($_GET['edit_id']) ? 'Edit' : 'Add'; ?> Customer</h2>
            <form action="customers.php" method="post">
                <?php
                if (isset($_GET['edit_id'])) {
                    $edit_id = $_GET['edit_id'];
                    $edit_result = mysql_query("SELECT * FROM users WHERE id='$edit_id' AND user_type='customer'", $conn);
                    $edit_row = mysql_fetch_assoc($edit_result);
                    echo "<input type='hidden' name='id' value='{$edit_row['id']}'>";
                }
                ?>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($edit_row['username']) ? $edit_row['username'] : ''; ?>" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($edit_row['email']) ? $edit_row['email'] : ''; ?>" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit"><?php echo isset($_GET['edit_id']) ? 'Update' : 'Add'; ?> Customer</button>
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
