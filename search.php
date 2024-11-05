<?php
include 'db_connect.php';

// Retrieve the search query from the URL
$query = $_GET['query'];

// Escape the query to prevent SQL injection
$query = mysql_real_escape_string($query, $conn);

// Perform the search query
$sql = "SELECT * FROM menu WHERE name LIKE '%$query%' OR description LIKE '%$query%'";
$result = mysql_query($sql, $conn);

// Check for query errors
if (!$result) {
    die("Error executing query: " . mysql_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Search Results</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="menu.html">Menu</a></li>
            <li><a href="gallery.html">Gallery</a></li>
            <li><a href="reservation.html">Reservation</a></li>
            <li><a href="preorder.html">Preorder</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="register.html">Register</a></li>
            <li><a href="search.html">Search</a></li>
        </ul>
    </nav>
    <main>
        <div class="container">
            <?php
            if (mysql_num_rows($result) > 0) {
                echo "<ul>";
                while ($row = mysql_fetch_assoc($result)) {
                    echo "<li><strong>" . $row["name"] . "</strong>: " . $row["description"] . ": Rs." . $row["price"] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "No results found for your search.";
            }
            mysql_close($conn);
            ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 The Gallery Café</p>
    </footer>
</body>
</html>
