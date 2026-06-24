<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "exam_portal";

// Database Connection
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


?>
