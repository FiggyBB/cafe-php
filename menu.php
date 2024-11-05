<?php
include 'db_connect.php';
session_start(); // Start the session

// Correct authorization logic
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.html');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysql_real_escape_string($_POST['name']);
    $description = mysql_real_escape_string($_POST['description']);
    $price = mysql_real_escape_string($_POST['price']);

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        // Update an existing menu item
        $id = $_POST['id'];
        $sql = "UPDATE menu SET name='$name', description='$description', price='$price' WHERE id='$id'";
        if (mysql_query($sql, $conn)) {
            echo "Menu item updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysql_error($conn);
        }
    } else {
        // Add a new menu item
        $sql = "INSERT INTO menu (name, description, price) VALUES ('$name', '$description', '$price')";
        if (mysql_query($sql, $conn)) {
            echo "New menu item created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysql_error($conn);
        }
    }
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM menu WHERE id='$id'";
    if (mysql_query($sql, $conn)) {
        echo "Menu item deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysql_error($conn);
    }
}

$result = mysql_query("SELECT * FROM menu", $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Menu</h1>
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
            <h2>Menu List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysql_num_rows($result) > 0) {
                        while ($row = mysql_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['description']}</td>
                                    <td>{$row['price']}</td>
                                    <td>
                                        <a href='menu.php?edit_id={$row['id']}'>Edit</a> |
                                        <a href='menu.php?delete_id={$row['id']}'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No menu items found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <h2><?php echo isset($_GET['edit_id']) ? 'Edit' : 'Add'; ?> Menu Item</h2>
            <form action="menu.php" method="post">
                <?php
                if (isset($_GET['edit_id'])) {
                    $edit_id = $_GET['edit_id'];
                    $edit_result = mysql_query("SELECT * FROM menu WHERE id='$edit_id'", $conn);
                    $edit_row = mysql_fetch_assoc($edit_result);
                    echo "<input type='hidden' name='id' value='{$edit_row['id']}'>";
                }
                ?>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($edit_row['name']) ? $edit_row['name'] : ''; ?>" required>
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo isset($edit_row['description']) ? $edit_row['description'] : ''; ?></textarea>
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="<?php echo isset($edit_row['price']) ? $edit_row['price'] : ''; ?>" required>
                <button type="submit"><?php echo isset($_GET['edit_id']) ? 'Update' : 'Add'; ?> Menu Item</button>
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
