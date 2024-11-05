`<?php
include 'db_connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Simple email validation
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Insert the contact form submission into the database
        $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysql_query($sql, $conn)) {
            $message = 'Message saved successfully!';
        } else {
            $message = 'Failed to save message: ' . mysql_error($conn);
        }
    } else {
        $message = 'Invalid email address.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Contact Us</h1>
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
            <a href="contact.html">Go back to Contact Page</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 The Gallery Café</p>
    </footer>
</body>
</html>
