<?php

include 'db_connect.php';
session_start(); // Start the session

/**
 * Process the login form submission.
 *
 * This script handles the login functionality by validating the user credentials
 * against the database. If the credentials are valid, it starts a session and
 * redirects the user to the appropriate page based on their user type.
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape user input to prevent SQL injection
    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);

    // Query to fetch user details based on the provided username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysql_query($sql);

    // Check if the user exists
    if (mysql_num_rows($result) > 0) {
        // Fetch the user details
        $row = mysql_fetch_assoc($result);

        // Verify the password
        if ($password == $row['password']) {
            // Store user information in session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_type'] = $row['user_type'];

            // Redirect based on user type
            if ($row['user_type'] == 'admin') {
                header('Location: dashboard.php');
                exit();
            } else {
                header('Location: index.html');
                exit();
            }
        } else {
            // Invalid password message
            echo 'Invalid password.';
        }
    } else {
        // No user found message
        echo 'No user found.';
    }
}
?>
