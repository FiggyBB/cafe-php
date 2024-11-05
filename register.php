<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape user input to prevent SQL injection
    $username = mysql_real_escape_string($_POST['username']);
    $email = mysql_real_escape_string($_POST['email']);
    $password = mysql_real_escape_string($_POST['password']);

    // SQL query to insert the new user into the database
    $sql = "INSERT INTO users (username, email, password, user_type) VALUES ('$username', '$email', '$password', 'customer')";

    // Execute the query and check if the insertion was successful
    if (mysql_query($sql)) {
        // Registration successful, redirect to login page
        // echo 'Registration successful!';
        header('Location: login.html');
    } else {
        // Error occurred, display error message
        echo 'Error: ' . $sql . '<br>' . mysql_error();
    }
}
?>
