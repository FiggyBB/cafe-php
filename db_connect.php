<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'restaurant';

$conn = mysql_connect($servername, $username, $password);
if (! $conn) {
    die('Connection failed: ' . mysql_error());
}

mysql_select_db($dbname, $conn);
