<?php
// mysql database connection
// change these for your server

$db_host = "localhost";
$db_user = "root";
$db_pass = "";  // empty for xampp
$db_name = "airline_db";

// create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// set character set
$conn->set_charset("utf8mb4");
?>