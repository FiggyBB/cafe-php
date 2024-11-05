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

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysql_query($sql, $conn)) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . mysql_error($conn) . "\n";
}

// Select the database
mysql_select_db($dbname, $conn);

// Create reservations table
$sql = "CREATE TABLE IF NOT EXISTS reservations (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    guests INT(11) NOT NULL,
    PRIMARY KEY (id)
)";
if (mysql_query($sql, $conn)) {
    echo "Table reservations created successfully\n";
} else {
    echo "Error creating table: " . mysql_error($conn) . "\n";
}

// Create preorders table
$sql = "CREATE TABLE IF NOT EXISTS preorders (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    meal VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    PRIMARY KEY (id)
)";
if (mysql_query($sql, $conn)) {
    echo "Table preorders created successfully\n";
} else {
    echo "Error creating table: " . mysql_error($conn) . "\n";
}

// Create contacts table
$sql = "CREATE TABLE IF NOT EXISTS contacts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    PRIMARY KEY (id)
)";
if (mysql_query($sql, $conn)) {
    echo "Table contacts created successfully\n";
} else {
    echo "Error creating table: " . mysql_error($conn) . "\n";
}

// Create staff table
$sql = "CREATE TABLE IF NOT EXISTS staff (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)";
if (mysql_query($sql, $conn)) {
    echo "Table staff created successfully\n";
} else {
    echo "Error creating table: " . mysql_error($conn) . "\n";
}

// Create menu table
$sql = "CREATE TABLE IF NOT EXISTS menu (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (id)
)";
if (mysql_query($sql, $conn)) {
    echo "Table menu created successfully\n";
} else {
    echo "Error creating table: " . mysql_error($conn) . "\n";
}

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
)";
if (mysql_query($sql, $conn)) {
    echo "Table users created successfully\n";
} else {
    echo "Error creating table: " . mysql_error($conn) . "\n";
}

// Insert default admin user
$sql = "INSERT INTO users (username, email, password, user_type) VALUES ('admin', 'admin@example.com', 'password', 'admin')";
if (mysql_query($sql, $conn)) {
    echo "Default admin user created successfully\n";
} else {
    echo "Error creating admin user: " . mysql_error($conn) . "\n";
}

mysql_close($conn);
?>
