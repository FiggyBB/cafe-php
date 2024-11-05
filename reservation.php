<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Reservation - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Table Reservation</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="menu.html">Menu</a></li>
            <li><a href="gallery.html">Gallery</a></li>
            <li><a href="search.html">Search</a></li>
            <li><a href="reservation.html">Reservation</a></li>
            <li><a href="preorder.html">Preorder</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="register.html">Register</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <div class="form-container">
            <p><?php echo $message; ?></p>
            <a href="reservation.html">Go back to Reservation Page</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 The Gallery Café</p>
    </footer>
</body>
</html>
