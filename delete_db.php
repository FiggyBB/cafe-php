<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

// Create connection
$conn = mysql_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysql_error());
}

// Drop the database
$sql = "DROP DATABASE IF EXISTS $dbname";
if (mysql_query($sql, $conn)) {
    echo "Database deleted successfully\n";
} else {
    echo "Error deleting database: " . mysql_error($conn) . "\n";
}

mysql_close($conn);
