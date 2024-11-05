<?php
include 'db_connect.php';
session_start(); // Start the session

// Correct authorization logic
if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] !== 'admin' && $_SESSION['user_type'] !== 'staff')) {
    header('Location: login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && $_POST['id'] !== '') {
        // Update an existing preorder
        $id = $_POST['id'];
        $name = $_POST['name'];
        $meal = $_POST['meal'];
        $date = $_POST['date'];

        $sql = "UPDATE preorders SET name='$name', meal='$meal', date='$date' WHERE id='$id'";
        if (mysql_query($sql, $conn)) {
            echo 'Preorder updated successfully';
        } else {
            echo 'Error: ' . $sql . '<br>' . mysql_error($conn);
        }
    } else {
        // Add a new preorder
        $name = $_POST['name'];
        $meal = $_POST['meal'];
        $date = $_POST['date'];

        $sql = "INSERT INTO preorders (name, meal, date) VALUES ('$name', '$meal', '$date')";
        if (mysql_query($sql, $conn)) {
            echo 'New preorder created successfully';
        } else {
            echo 'Error: ' . $sql . '<br>' . mysql_error($conn);
        }
    }
}

if (isset($_GET['delete_id'])) {
    // Delete a preorder
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM preorders WHERE id='$id'";
    if (mysql_query($sql, $conn)) {
        echo 'Preorder deleted successfully';
    } else {
        echo 'Error: ' . $sql . '<br>' . mysql_error($conn);
    }
}

$result = mysql_query('SELECT * FROM preorders', $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Preorders - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Preorders</h1>
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
            <h2>Preorders List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Meal</th>
                        <th>Date</th>
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
                                    <td>{$row['meal']}</td>
                                    <td>{$row['date']}</td>
                                    <td>
                                        <a href='preorders.php?edit_id={$row['id']}'>Edit</a> |
                                        <a href='preorders.php?delete_id={$row['id']}'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No preorders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <h2><?php echo isset($_GET['edit_id']) ? 'Edit' : 'Add'; ?> Preorder</h2>
            <form action="preorders.php" method="post">
                <?php
                if (isset($_GET['edit_id'])) {
                    $edit_id = $_GET['edit_id'];
                    $edit_result = mysql_query("SELECT * FROM preorders WHERE id='$edit_id'", $conn);
                    $edit_row = mysql_fetch_assoc($edit_result);
                    echo "<input type='hidden' name='id' value='{$edit_row['id']}'>";
                }
                ?>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($edit_row['name']) ? $edit_row['name'] : ''; ?>" required>
                <label for="meal">Meal:</label>
                <input type="text" id="meal" name="meal" value="<?php echo isset($edit_row['meal']) ? $edit_row['meal'] : ''; ?>" required>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo isset($edit_row['date']) ? $edit_row['date'] : ''; ?>" required>
                <button type="submit"><?php echo isset($_GET['edit_id']) ? 'Update' : 'Add'; ?> Preorder</button>
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
