<?php
include("../../config/db.php");

// Get form data
$name     = $_POST['name'];
$email    = $_POST['email'];
$enroll   = $_POST['enroll'];
$password = $_POST['password'];

// Check if email or enrollment already exists
$check = "SELECT * FROM students WHERE email='$email' OR enrollment='$enroll'";
$result = mysqli_query($conn, $check);

if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('Email or Enrollment Number already exists'); window.location.href='../student_register.php';</script>";
    exit();
}

// Hash password
$hashed_pass = md5($password);

// Insert student
$query = "INSERT INTO students (name, email, enrollment, password) 
          VALUES ('$name', '$email', '$enroll', '$hashed_pass')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Registration Successful! You can login now'); window.location.href='../student_login.php';</script>";
} else {
    echo "<script>alert('Error occurred. Try again.'); window.location.href='../student_register.php';</script>";
}
?>
