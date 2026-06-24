<?php
session_start();
require_once("../../config/db.php");

$email = $_POST['email'];
$password = md5($_POST['password']); // legacy

$stmt = $conn->prepare(
    "SELECT id, name, status FROM students WHERE email = ? AND `password` = ? LIMIT 1"
);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $name, $status);

if ($stmt->fetch()) {

    if ($status == 0) {
        echo "<script>alert('Contact admin.'); window.location.href='../student_login.php';</script>";
        exit();
    }

    $_SESSION['student_id'] = $id;
    $_SESSION['student_name'] = $name;

    header("Location: ../../student/dashboard.php");
    exit();
}

echo "<script>alert('Invalid Credentials'); window.location.href='../student_login.php';</script>";
exit();
