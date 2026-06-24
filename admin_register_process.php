<?php
include("../../config/db.php");

// Form data
$name     = $_POST['admin_name'];
$email    = $_POST['admin_email'];
$key      = $_POST['admin_key'];
$password = $_POST['admin_password'];

// SECURITY: Secret Admin Key
$REAL_ADMIN_KEY = "EXAMADMIN123";  // Change this as you like

if ($key !== $REAL_ADMIN_KEY) {
    echo "<script>alert('Invalid Admin Secret Key'); window.location.href='../admin_register.php';</script>";
    exit();
}

// Duplicate check
$check = "SELECT * FROM admins WHERE admin_email='$email'";
$result = mysqli_query($conn, $check);

if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('Admin Email already exists'); window.location.href='../admin_register.php';</script>";
    exit();
}

// Hash password
$hashed = md5($password);

// Insert admin
$query = "INSERT INTO admins (admin_name, admin_email, admin_key, admin_password) 
          VALUES ('$name', '$email', '$key', '$hashed')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Admin Registered Successfully! Login now.'); window.location.href='../ADMIN_login.php';</script>";
} else {
    echo "<script>alert('Error occurred. Try again.'); window.location.href='../admin_register.php';</script>";
}
?>
