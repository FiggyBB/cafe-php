<?php
include 'db_connect.php';
session_start(); // Start the session

// Correct authorization logic
if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] !== 'admin' && $_SESSION['user_type'] !== 'staff')) {
    header('Location: login.html');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && $_POST['id'] !== '') {
        // Update an existing reservation
        $id = $_POST['id'];
        $name = $_POST['name'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $guests = $_POST['guests'];

        $sql = "UPDATE reservations SET name='$name', date='$date', time='$time', guests='$guests' WHERE id='$id'";
        if (mysql_query($sql, $conn)) {
            echo "Reservation updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysql_error($conn);
        }
    } else {
        // Add a new reservation
        $name = $_POST['name'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $guests = $_POST['guests'];

        $sql = "INSERT INTO reservations (name, date, time, guests) VALUES ('$name', '$date', '$time', '$guests')";
        if (mysql_query($sql, $conn)) {
            echo "New reservation created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysql_error($conn);
        }
    }
}

if (isset($_GET['delete_id'])) {
    // Delete a reservation
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM reservations WHERE id='$id'";
    if (mysql_query($sql, $conn)) {
        echo "Reservation deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysql_error($conn);
    }
}

$result = mysql_query("SELECT * FROM reservations", $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reservations - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Reservations</h1>
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
            <h2>Reservations List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Guests</th>
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
                                    <td>{$row['date']}</td>
                                    <td>{$row['time']}</td>
                                    <td>{$row['guests']}</td>
                                    <td>
                                        <a href='reservations.php?edit_id={$row['id']}'>Edit</a> |
                                        <a href='reservations.php?delete_id={$row['id']}'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No reservations found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <h2><?php echo isset($_GET['edit_id']) ? 'Edit' : 'Add'; ?> Reservation</h2>
            <form action="reservations.php" method="post">
                <?php
                if (isset($_GET['edit_id'])) {
                    $edit_id = $_GET['edit_id'];
                    $edit_result = mysql_query("SELECT * FROM reservations WHERE id='$edit_id'", $conn);
                    $edit_row = mysql_fetch_assoc($edit_result);
                    echo "<input type='hidden' name='id' value='{$edit_row['id']}'>";
                }
                ?>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($edit_row['name']) ? $edit_row['name'] : ''; ?>" required>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo isset($edit_row['date']) ? $edit_row['date'] : ''; ?>" required>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" value="<?php echo isset($edit_row['time']) ? $edit_row['time'] : ''; ?>" required>
                <label for="guests">Guests:</label>
                <input type="number" id="guests" name="guests" value="<?php echo isset($edit_row['guests']) ? $edit_row['guests'] : ''; ?>" required>
                <button type="submit"><?php echo isset($_GET['edit_id']) ? 'Update' : 'Add'; ?> Reservation</button>
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
