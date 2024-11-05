<?php
include 'db_connect.php';
session_start(); // Start the session

// Correct authorization logic
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.html');
    exit();
}

// Get the number of staff
$staff_result = mysql_query("SELECT COUNT(*) as total_staff FROM staff", $conn);
$staff_count_row = mysql_fetch_assoc($staff_result);
$staff_count = $staff_count_row['total_staff'];

// Get the number of reservations
$reservations_result = mysql_query("SELECT COUNT(*) as total_reservations FROM reservations", $conn);
$reservations_count_row = mysql_fetch_assoc($reservations_result);
$reservations_count = $reservations_count_row['total_reservations'];

// Get the number of preorders
$preorders_result = mysql_query("SELECT COUNT(*) as total_preorders FROM preorders", $conn);
$preorders_count_row = mysql_fetch_assoc($preorders_result);
$preorders_count = $preorders_count_row['total_preorders'];

mysql_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
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
            <h2>Statistics</h2>
            <div class="stats">
                <div class="stat-item">
                    <h3>Total Staff</h3>
                    <p><?php echo $staff_count; ?></p>
                </div>
                <div class="stat-item">
                    <h3>Total Reservations</h3>
                    <p><?php echo $reservations_count; ?></p>
                </div>
                <div class="stat-item">
                    <h3>Total Preorders</h3>
                    <p><?php echo $preorders_count; ?></p>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 The Gallery Café</p>
    </footer>
</body>
</html>
